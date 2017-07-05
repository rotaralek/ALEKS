<?php
/*
  * Template name: Template Home
  * */
get_header();

//Top posts
get_template_part('partials/home-page/top-posts');

//Posts
get_template_part('partials/home-page/posts');

get_footer(); ?>