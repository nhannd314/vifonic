<?php
/**
 * The sidebar containing the left widget area.
 */

if (!is_active_sidebar('sidebar-main')) return;

?>

<?php dynamic_sidebar( 'sidebar-main' ); ?>