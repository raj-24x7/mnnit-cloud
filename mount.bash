#!/bin/bash

ip=$1
username=$2
password=$3
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

echo $password | sshfs -o allow_other -o password_stdin $username@$ip: $DIR/files/$username
