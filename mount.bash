#!/bin/bash

ip=$1
username=$2
password=$3
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

echo $password | sshfs -o cache=no -o allow_other -o password_stdin root@$ip:/home/$username $DIR/files/$username
