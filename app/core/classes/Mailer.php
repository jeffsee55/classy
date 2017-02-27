<?php
/**
* The core theme class.
*
* @since 	1.0.0
* @package Classy
* @author 	Andrew Tolochka <atolochka@gmail.com>
*/

namespace Classy;

use Windwalker\Renderer\BladeRenderer;
use Classy\Models\Post;

class Mailer
{

   public static function view($name, $data = [])
   {
       $paths = [CLASSY_THEME_PATH . 'views/'];
       $renderer = new BladeRenderer($paths, array('cache_path' => CLASSY_THEME_PATH . 'cache'));
       return $renderer->render($name, $data);
   }

   public function mailtrap($phpmailer)
   {

      $phpmailer->isSMTP();
      $phpmailer->Host = 'smtp.mailtrap.io';
      $phpmailer->SMTPAuth = true;
      $phpmailer->Port = 2525;
      $phpmailer->Username = '8661db25c9b5dd';
      $phpmailer->Password = 'dde285839762da';
   }

   public static function sendVerification($email)
   {
      $message = get_field('verify_subscription', 'option') ? get_field('verify_subscription', 'option') : 'Thanks for signing up for ' . get_bloginfo('name') . ' email notices.';

      $html = self::view('emails.verify', ['email' => $email, 'message' => $message]);

      $headers = array('Content-Type: text/html; charset=UTF-8');

      wp_mail($email, 'Verify Mailer', $html, $headers);
   }

   public static function sendNotification($post_id)
   {
      $post = new Post(intval($post_id));

      $message = get_field('subscription_alert_message', 'option') ? get_field('subscription_alert_message', 'option') : 'Thanks for subscribing to ' . get_bloginfo('name') . '.';

      $headers = array('Content-Type: text/html; charset=UTF-8');

      $args = [
         'role' => 'subscriber',
         'meta_key' => 'verified',
         'meta_value' => '1',
         'fields' => ['user_email']
      ];
      $subscribers = array_column(get_users($args), 'user_email');

      array_map(function($email) use ($post, $html, $headers, $message) {
         $html = self::view('emails.notify', ['post' => $post, 'message' => $message, 'email' => $email]);

         wp_mail($email, str_replace("&amp;", "&", get_bloginfo('name')) . ' | ' . $post->post_title, $html, $headers);
      }, $subscribers);

      wp_redirect($_SERVER['HTTP_REFERER'] . '&message=1');
   }
}
