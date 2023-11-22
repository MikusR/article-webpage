start /B npx tailwindcss -i ./resources/css/input.css -o ./public/css/style.generated.css --watch
start /B php -S localhost:8765 -t public/