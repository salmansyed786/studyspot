<script src="https://cdn.tiny.cloud/1/5a8wqgbattaow0xq2sww1dwrn5pvgl8lmg4bmp7bej4k5nsa/tinymce/5/tinymce.min.js" referrerpolicy="origin" defer></script>
<script defer>
    // Initialize TinyMCE Editor
    tinymce.init({
        selector: 'textarea#my_tinymce',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        height: '55vh',
        resize: false,
        mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' },
        ]
    });
</script>