
## How do I use this for my Pterodactyl Panel?
The theme has a small code snippet (build.sh) that you must install into `/var/www/pterodactyl`

## Image:
![example](https://github.com/minenite/paneltheme/blob/master/Pterodactyl.png?raw=true)

## Steps to install:
1. Download or make `build.sh` in `/var/www/pterodactyl`
2. Make sure the build.sh has permissions to run `chmod +x /var/www/pterodactyl/build.sh`
3. Run `./build.sh` in `/var/www/pterodactyl`
4. Modify the .env file `nano /var/www/pterodactyl/.env` change pterodactyltheme to `argon`
5. Run these commands after you saved the file: `php artisan theme:refresh-cache` `php artisan view:clear`
6. Refresh the browser `CTRL+F5` Success.
## FAQ:
What if this script doesn't work? A:
The implementation command will take a backup of your current panel in case anything goes wrong during the theme change! So you don't need to worry about losing anything you've already made!



## Suggestions
If theres something you want added, just head over to the issues tab and type away.

## Themes Ready for you to use:
`argon`

https://pterodactyl.io/panel/configuration.html
