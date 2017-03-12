<?php
/*
Plugin Name: Meta box cho chương trình
Author: Lành TV
Description: Tạo meta box cho loại post là chương trình
Author URI: http://vanlanh.xyz
*/

/**
 Khai báo meta box nội dung học
**/
function chuongtrinh_noi_dung_meta_box()
{
	add_meta_box( 'noi-dung', 'Nội dung học', 'chuongtrinh_noi_dung_output', 'chuong_trinh' );
}
add_action( 'add_meta_boxes', 'chuongtrinh_noi_dung_meta_box' );

function chuongtrinh_noi_dung_output($post)
{
	$noi_dung_hoc = get_post_meta( $post->ID, '_noi_dung_hoc', true );
	wp_editor(htmlspecialchars_decode($noi_dung_hoc) , 'noi_dung_hoc', array(
		"media_buttons" => true
	));
}

function chuongtrinh_noi_dung_save( $post_id )
{
	if (!empty($_POST['noi_dung_hoc']))
	{
		$noi_dung_hoc = htmlspecialchars($_POST['noi_dung_hoc']);
		update_post_meta($post_id, '_noi_dung_hoc', $noi_dung_hoc);
	}
}
add_action( 'save_post', 'chuongtrinh_noi_dung_save' );

/**
 Khai báo meta box thời gian
**/
function chuongtrinh_thoi_gian_meta_box()
{
	add_meta_box( 'thoi-gian', 'Thời gian', 'chuongtrinh_thoi_gian_output', 'chuong_trinh' );
}
add_action( 'add_meta_boxes', 'chuongtrinh_thoi_gian_meta_box' );

function chuongtrinh_thoi_gian_output($post)
{
	$thoi_gian = get_post_meta( $post->ID, '_thoi_gian', true );
	echo ( '<label for="thoi_gian">Khóa học kéo dài: </label>' );
	echo ('<input type="text" id="thoi_gian" name="thoi_gian" value="'.esc_attr( $thoi_gian ).'" />');
}

function chuongtrinh_thoi_gian_save( $post_id )
{
	$thoi_gian = sanitize_text_field( $_POST['thoi_gian'] );
	update_post_meta( $post_id, '_thoi_gian', $thoi_gian );
}
add_action( 'save_post', 'chuongtrinh_thoi_gian_save' );

/**
 Khai báo meta box số học viên
**/
function chuongtrinh_hoc_vien_meta_box()
{
	add_meta_box( 'hoc-vien', 'Số học viên', 'chuongtrinh_hoc_vien_output', 'chuong_trinh' );
}
add_action( 'add_meta_boxes', 'chuongtrinh_hoc_vien_meta_box' );

function chuongtrinh_hoc_vien_output($post)
{
	$hoc_vien = get_post_meta( $post->ID, '_hoc_vien', true );
	echo ( '<label for="hoc_vien">Số học viên: </label>' );
	echo ('<input type="text" id="hoc_vien" name="hoc_vien" value="'.esc_attr( $hoc_vien ).'" />');
}

function chuongtrinh_hoc_vien_save( $post_id )
{
	$hoc_vien = sanitize_text_field( $_POST['hoc_vien'] );
	update_post_meta( $post_id, '_hoc_vien', $hoc_vien );
}
add_action( 'save_post', 'chuongtrinh_hoc_vien_save' );


/**
 Khai báo meta box học phí
**/
function chuongtrinh_hoc_phi_meta_box()
{
	add_meta_box( 'hoc-phi', 'Học phí', 'chuongtrinh_hoc_phi_output', 'chuong_trinh' );
}
add_action( 'add_meta_boxes', 'chuongtrinh_hoc_phi_meta_box' );

function chuongtrinh_hoc_phi_output($post)
{
	$hoc_phi = get_post_meta( $post->ID, '_hoc_phi', true );
	echo ( '<label for="hoc_phi">Học phí: </label>' );
	echo ('<input type="text" id="hoc_phi" name="hoc_phi" value="'.esc_attr( $hoc_phi ).'" />');
}

function chuongtrinh_hoc_phi_save( $post_id )
{
	$hoc_phi = sanitize_text_field( $_POST['hoc_phi'] );
	update_post_meta( $post_id, '_hoc_phi', $hoc_phi );
}
add_action( 'save_post', 'chuongtrinh_hoc_phi_save' );