# Suitcase Interim

Suitcase Interim is a mobile-first Drupal 7 theme. It is an implementation of the [IASTATE theme] that provides the Iowa State University look and feel.

It has been optimized for use with [Luggage_ISU] (recommended) but will also work with stock Drupal 7.

## Requirements

This theme requires the [Omega base theme (7.x-3.x-dev)].

## Installation with Luggage_ISU

If you are using [Luggage_ISU] 5.x then Suitcase Interim and Omega have been automatically included.

## Installation with Stock Drupal 7

Download the [Omega base theme (7.x-3.x-dev)] first and then download Suitcase Interim. 

    cd sites/all/themes
    curl -O https://ftp.drupal.org/files/projects/omega-7.x-3.x-dev.zip
    unzip omega-7.x-3.x-dev.zip && rm omega-7.x-3.x-dev.zip 
    drush en omega suitcase_interim -y
    drush vset admin_theme seven
    
When you are done, you should have sites/all/themes/omega and sites/all/themes/suitcase_interim. In your browser, navigate to Administration / Appearance, click "Enable and set default" under Suitcase Interim. Then modify Settings for Suitcase Interim.

## Browser Support
- Chrome
- Safari
- Firefox
- Opera
- IE 9+

## Troubleshooting

Read/Search [Luggage Documentation][]

Join us on the FreeNode IRC network in the #luggage channel. If you need help setting up IRC see https://www.drupal.org/irc/setting-up

## License

[GPLv2][]

**Open Source | Open Access | Open Mind**

[GPLv2]:http://www.gnu.org/licenses/gpl-2.0.html
[Luggage Documentation]:http://www.biology-it.iastate.edu/luggage_doc/
[Luggage]:http://www.biology-it.iastate.edu/luggage_doc/
[IASTATE theme]:https://www.theme.iastate.edu
[Luggage_ISU]:https://github.com/isubit/luggage_isu
[Omega base theme (7.x-3.x-dev)]:https://ftp.drupal.org/files/projects/omega-7.x-3.x-dev.zip
