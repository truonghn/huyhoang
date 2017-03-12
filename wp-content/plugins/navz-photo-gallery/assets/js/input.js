(function($) {

    function initialize_field($el) {
        //$el.doStuff();
    }

    $(document).ready(function() {
        $(".acf-photo-gallery-metabox-list").sortable({
            containment: "parent",
            placeholder: "acf-photo-gallery-sortable-placeholder",
            tolerance: 'pointer'
        }).disableSelection();
    });

    function acf_photo_gallery_edit(id, url, title, caption) {
        var html;
        html = '<div id="acf-photo-gallery-metabox-edit-' + id + '" class="acf-edit-photo-gallery">';
        html += '<h3>Edit Image</h3>';
        html += '<label>URL</label><input type="text" value="' + url + '"/>';
        html += '<label><input type="checkbox" value="1"/>Open in new tab</label>';
        html += '<label>Title</label><input type="text" value="' + title + '"/>';
        html += '<label>Caption</label><textarea>' + caption + '</textarea>';
        html += '<button class="button button-primary button-large" type="button">Save Changes</button>';
        html += '<button class="button button-large button-close" type="button" data-close="' + id + '">Close</button>';
        html += '</div>';
        return html;
    }

    function acf_photo_gallery_html(attachment, field) {
        var html, id, url, title, caption;
        id = attachment.id;
        url = attachment.url;
        title = attachment.title;
        caption = attachment.caption;

        if (typeof attachment.sizes.thumbnail != 'undefined') {
            url = attachment.sizes.thumbnail.url
        }

        html = acf_photo_gallery_edit(id, url, title, caption);
        $('#acf-' + field + ' .acf-photo-gallery-metabox-edit').append(html);
        $('#acf-' + field + ' .acf-photo-gallery-metabox-list').prepend('<li id="acf-photo-gallery-mediabox-' + id + '"><a class="dashicons dashicons-edit" href="#" title="Edit" data-id="' + id + '"></a><a class="dashicons dashicons-dismiss" href="#" data-id="' + id + '" data-field="' + field + '" title="Remove this photo from the gallery"></a><input type="hidden" name="' + field + '[]" value="' + id + '"/><img src="' + url + '"/></li>');
    }

    function acf_photo_gallery_add_media($el) {
        var acf_photo_gallery_ids = new Array();
        if ($('#acf-photo-gallery-metabox-add-images').length > 0) {
            if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
                $('.wrap').on('click', '#acf-photo-gallery-metabox-add-images', function(e) {
                    e.preventDefault();
                    var button = $(this);
                    var id = button.prev();
                    var field = button.attr('data-id');
                    wp.media.editor.send.attachment = function(props, attachment) {
                        acf_photo_gallery_html(attachment, field);
                    };
                    wp.media.editor.open(button);
                    if ($('#acf-' + field + ' .acf-photo-gallery-metabox-list li.acf-photo-gallery-media-box-placeholder').length > 0) {
                        $('#acf-' + field + ' .acf-photo-gallery-metabox-list li.acf-photo-gallery-media-box-placeholder').remove();
                    }
                    return false;
                });
            }
        };
    }

    function acf_photo_gallery_remove_photo() {

        $(document).on('click', '.acf-photo-gallery-metabox-list .dashicons-dismiss', function() {
            var url = $(this).attr('href');
            var id = $(this).attr('data-id');
            var field = $(this).attr('data-field');
            if (confirm('You are about to remove this photo from the gallery. Are you sure?')) {
                $.get(url, function(data) {
                    $('#acf-' + field + ' #acf-photo-gallery-mediabox-' + id).fadeOut('fast').remove();
                    if ($('#acf-' + field + ' .acf-photo-gallery-metabox-list li').length < 1) {
                        $('#acf-' + field + ' .acf-photo-gallery-metabox-list').append('<li class="acf-photo-gallery-media-box-placeholder"><span class="dashicons dashicons-format-image"></span></li>');
                    }
                });
            }
            return false;
        });

        $(document).on('click', '#acf-photo-gallery-metabox-edit .acf-edit-photo-gallery button.button-close', function() {
            var id;
            id = $(this).attr('data-close');
            $('#acf-photo-gallery-metabox-edit #acf-photo-gallery-metabox-edit-' + id).fadeOut('fast');
            return false;
        });

    }

    $(document).on('click', '#acf-photo-gallery-metabox-edit .acf-edit-photo-gallery button.button-primary', function() {
        var button, field, data, post, attachment, action, nonce, form = {};
        action = 'acf_photo_gallery_edit_save';
        attachment = $(this).attr('data-id');

        $('#acf-photo-gallery-metabox-edit-' + attachment + ' .acf-photo-gallery-edit-field').each(function(i, obj) {
            if (obj.name == 'acf-pg-hidden-action') {
                form['action'] = obj.value;
            } else {
                form[obj.name] = obj.value;
            }
        });

        button = $(this);
        button.attr('disabled', true).html('Saving...');
        $.post(acf.ajaxurl, form, function(data) {
            button.attr('disabled', false).html('Save Changes');
            $('#acf-photo-gallery-metabox-edit #acf-photo-gallery-metabox-edit-' + attachment).fadeOut('fast');
        });
        return false;
    });

    function acf_photo_gallery_edit_popover() {
        $(document).on('click', '.acf-photo-gallery-metabox-list .dashicons-edit', function() {
            var id;
            id = $(this).attr('data-id');
            $('#acf-photo-gallery-metabox-edit #acf-photo-gallery-metabox-edit-' + id).fadeToggle('fast');
            return false;
        });
    }

    if (typeof acf.add_action !== 'undefined') {
        /*
         *  ready append (ACF5)
         *
         *  These are 2 events which are fired during the page load
         *  ready = on page load similar to $(document).ready()
         *  append = on new DOM elements appended via repeater field
         *
         *  @type	event
         *  @date	20/07/13
         *
         *  @param	$el (jQuery selection) the jQuery element which contains the ACF fields
         *  @return	n/a
         */
        acf.add_action('ready append', function($el) {
            // search $el for fields of type 'photo_gallery'
            acf.get_fields({ type: 'photo_gallery' }, $el).each(function() {
                initialize_field($(this));
                acf_photo_gallery_add_media($(this));
                acf_photo_gallery_remove_photo($(this));
                acf_photo_gallery_edit_popover($(this));
            });
        });
    } else {
        /*
         *  acf/setup_fields (ACF4)
         *
         *  This event is triggered when ACF adds any new elements to the DOM. 
         *
         *  @type	function
         *  @since	1.0.0
         *  @date	01/01/12
         *
         *  @param	event		e: an event object. This can be ignored
         *  @param	Element		postbox: An element which contains the new HTML
         *
         *  @return	n/a
         */
        $(document).on('acf/setup_fields', function(e, postbox) {
            $(postbox).find('.field[data-field_type="photo_gallery"]').each(function() {
                initialize_field($(this));
                acf_photo_gallery_add_media($(this));
                acf_photo_gallery_remove_photo($(this));
                acf_photo_gallery_edit_popover($(this));
            });
        });
    }
})(jQuery);