{{-- Vendor Scripts --}}
<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/ui/prism.min.js')) }}"></script>
@yield('vendor-script')
{{-- Theme Scripts --}}
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>
@if($configData['blankPage'] === false)
<script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script>
@endif
{{-- page script --}}
@yield('page-script')
{{-- page script --}}

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
<script>
var BlogDescription = document.getElementById('BlogDescription');
if (BlogDescription) {
    ClassicEditor
        .create( document.querySelector( '#BlogDescription' ) )
        .catch( error => {
            console.error( error );
        } );
}
</script>
{{-- BlogImage --}}
<script>
var BlogImage = document.getElementById('BlogImage');
if (BlogImage) {
	BlogImage.addEventListener("change", function() {
	    const [file] = BlogImage.files
		if (file) {
			BlogActuallImage.src = URL.createObjectURL(file)
		}
	    BlogActuallImage.classList = '';
	    BlogSpan.innerHTML = '';
	});
}
</script>
