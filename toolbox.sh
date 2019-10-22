#!/usr/bin/env bash
cd `dirname $0`
if [ -z ${VOLUME_DIR+x} ]; then
	export VOLUME_DIR=`pwd`
fi

export ECO_DOCKER_DIR=`pwd`
export VOLUME_DIR="$ECO_DOCKER_DIR"

CONTAINER_TOOLBOX_ID=`docker ps --format '{{.ID}}\t{{.Names}}' | grep challengesymfony_eco_1 | cut -f1`

function ssh_to()
{
  if [ -z $1 ]; then
    # Connect to toolbox
    docker exec -t -i $CONTAINER_TOOLBOX_ID /bin/bash
  else
    # search container
    CONTAINER=`docker ps --format 'table {{.Names}}' | grep $1 | tr -d ' '`
    if [ -e $CONTAINER ]
    then
        echo "Container '$1' is not running!. Please select container from this list:"
        docker ps
    else
        docker exec -t -i $CONTAINER /bin/bash
    fi
  fi
}

function execute_arbitrary(){

	if [ -t 1 ] ; then
		docker exec -t -i $CONTAINER_TOOLBOX_ID $@
		RET=$?
	else
		echo "$Name Warning: running in a non-interactive environment. Some features may not work"
		docker exec $CONTAINER_TOOLBOX_ID $@
		RET=$?
	fi
	return $RET
}

function command_boot()
{
    # Start the developer environment
    docker-compose -f docker-compose.yml up &

    echo -n "Waiting for the services to initialize.. "
    while [[ ! $(docker ps | grep challengesymfony_eco_1) ]] ; do
        echo -n "."
        sleep 1
    done
    echo ""
    echo "composer install --prefer-source --no-interaction" |  docker exec -i  challengesymfony_eco_1 /bin/bash
    echo ""
}

function command_tests(){
    echo "composer test" |  docker exec -i  challengesymfony_eco_1 /bin/bash
}

function command_rebuild() {
    echo "Building image eco"
    docker build --no-cache -t eco .
    docker-compose -f docker-compose.yml build
}

function command_shutdown()
{
  docker-compose -f docker-compose.yml down $@
}

while (( "$#" )); do
  case "$1" in
  boot|up)
    shift
    command_boot $@
    exit
    ;;
  rebuild)
    command_rebuild;
    exit;
    ;;
  exec)
    shift
    execute_arbitrary $@
    exit $?
    ;;
  down)
    shift
    command_shutdown $@
    exit
    ;;
  tests)
    command_tests
    exit
    ;;
  ssh|connect)
    ssh_to $2
    exit
    ;;
   *)
   COMMAND=$@
   exit $?
   ;;
  esac
done