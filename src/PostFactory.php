<?php

namespace DaveJToews\WPViews;
use DaveJToews\WPViews\Helpers;

class PostFactory extends Factory {

	public static function create(\WP_Post $post, $namespace = null) {
		$view_class = self::get_view_class($post, $namespace);
		return new $view_class($post);
	}

	private static function get_view_class(\WP_Post $post, $namespace) {
		$post_type = get_post_type($post);
		$type_label = ($post_type === 'post') ? 'Blog' : self::get_label_string($post_type);
		$template_label = self::get_template_label( $post->ID );
		$post_string = "Post" . $type_label . $template_label;

		return self::get_namespaced_classname($post_string, $namespace);
	}

	private static function get_template_label($post_id) {

		$template_slug = get_page_template_slug( $post_id );
		$template_string = Helpers\get_string_between($template_slug, "template-", ".php");
		$template_label = self::get_label_string($template_string);

		if ($post_id === intval(get_option( 'page_on_front' ))) {
			$template_label = "Front";
		}

		return $template_label;
	}
}
