# FullCalendar Plugin for Wordpress</br>

<img src="https://i.ibb.co/vz5BxVm/calander.jpg" />

## Installation

1. Unzip file in your /wp-content/plugins directory.
2. Activate plugin in wp-admin.
3. Use shortcode [calendar-shortcode] to show calander in page.

## Nodification

To use the email nodification you need to add a cron job every minute.</br>
Add the folowing line to ```/etc/crontab```</br>
```1  *    * * *   root    /usr/bin/sudo php /var/www/you_hostname/wp-content/plugins/fullcalendar/includes/email-fullcalendar.php```</br>

## Changelog

- 4.0 - Add nodification.
- 0.3 - Add option to event to be public.
- 0.2 - Add button to add your own event to the calendar.
- 0.1 - Get events from AJAX.

## Credits

- https://github.com/fullcalendar/fullcalendar
- https://github.com/fengyuanchen/datepicker