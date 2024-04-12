#!/bin/sh

reset

function check_env_example() {
  local subpasta="$1"

  if [ -f "$subpasta/.env.example" ]; then
    if [ ! -f "$subpasta/.env" ]; then
        cp "$subpasta/.env.example" "$subpasta/.env"
    fi
  fi
}

# Create root .env
check_env_example .

# Create subfolders .env
for subpasta in */ ; do
  check_env_example "$subpasta"
done

docker compose up --build --force-recreate --remove-orphans
