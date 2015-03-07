#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd "$DIR/api" && ./start.sh &
cd "$DIR/developers" && ./start.sh &
cd "$DIR/web" && ./start.sh &

