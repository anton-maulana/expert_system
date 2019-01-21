$('.symptoms-lists').select2();     
tinymce.init({
	selector: 'textarea',  // change this value according to your HTML
	plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	content_style: `
	  @import url('https://fonts.googleapis.com/css?family=Noto+Serif');
	  body {
	    font-family: "Noto Serif"
	  }	`,
	  paste_data_images: true
  });