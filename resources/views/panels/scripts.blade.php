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
{{-- File manager --}}
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>

{{-- page script --}}
@yield('page-script')
{{-- page script --}}

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
{{-- FORMImage --}}
<script>
var FORMImage = document.getElementById('FORMImage');
if (FORMImage) {
	FORMImage.addEventListener("change", function() {
	    const [file] = FORMImage.files
		if (file) {
			FORMActuallImage.src = URL.createObjectURL(file)
		}
	    FORMActuallImage.classList = '';
	    FORMSpan.innerHTML = '';
	});
}
var ProgramsReset = document.getElementById('ProgramsReset');
if (ProgramsReset) {
	ProgramsReset.addEventListener("click", function() {
		FORMActuallImage.src = '';
		FORMActuallImage.classList.add("hidden");
		FORMSpan.innerHTML = 'اختر صورة (اختياري)';
	});
}
</script>

{{-- Program Units --}}
<style>
.Programsclose {
	background-color: #f7f4f1;
	border-radius: 50%;
	padding: 5px 10px;
	cursor: pointer;
	position: absolute;
	top: -2px;
	left: -2px;
}
.Programsclose:hover {
	background-color: #efefef;
	color:red;
	box-shadow: 0 1px 9px 3px #d9c3bd;
}
</style>
<script>
var AddUnit = document.getElementById('AddUnit');
var UnitsDiv = document.getElementById('UnitsDiv');
var DivBefore = document.getElementById('DivBefore');
if (AddUnit) {
	AddUnit.addEventListener("click", function() {
	
		var CDiv = document.createElement('div');
		CDiv.classList.add("col-md-6","col-12");
		CDiv.style.padding = '5px';

		var CDiv2 = document.createElement('div');
		CDiv2.classList.add("rounded", "border", "p-1");
		CDiv2.style.backgroundColor = 'rgb(144 143 147)';
		
		var CDinput1 = document.createElement('div');
		CDinput1.classList.add("form-group");
		var Cinput1 = document.createElement('input');
		Cinput1.classList.add("form-control");
		Cinput1.classList.add("ckeditor");
		Cinput1.name = "UnitNumber[]";
		Cinput1.placeholder = "رقم الوحدة (مطلوب)";
		Cinput1.required = true;
		CDinput1.append(Cinput1);
		CDiv2.append(CDinput1);

		var CDinput2 = document.createElement('div');
		CDinput2.classList.add("form-group");
		var Cinput2 = document.createElement('input');
		Cinput2.name = "UnitTitle[]";
		Cinput2.classList.add("form-control");
		Cinput2.placeholder = "عنوان الوحدة (مطلوب)";
		Cinput2.required = true;
		CDinput2.append(Cinput2);
		CDiv2.append(CDinput2);
		
		var CDtextarea = document.createElement('div');
		CDtextarea.classList.add("form-group");
		var Ctextarea = document.createElement('textarea');
		Ctextarea.name = "UnitContent[]";
		let CID = 'ckeditor' + Math.floor(Math.random() * 100) + 1;

		Ctextarea.setAttribute("id", CID);
		Ctextarea.classList.add("form-control");
		Ctextarea.placeholder = "محتوي الوحدة (اختياري)";
		CDtextarea.append(Ctextarea);
		CDiv2.append(CDtextarea);

		CDiv.append(CDiv2);
		var Cspan = document.createElement('span');
        Cspan.innerHTML = 'X';
        Cspan.classList.add('Programsclose');
        Cspan.onclick = function() {this.parentNode.remove()};
        CDiv.append(Cspan);
		
		UnitsDiv.append(CDiv,DivBefore);

		ClassicEditor.create( Ctextarea , {
			placeholder: 'محتوي الوحدة (اختياري)',
			toolbar: [ 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList' ,'Image'],
			heading: {
				options: [
					{ model: 'paragraph', title: 'نص', class: 'ck-heading_paragraph' },
					{ model: 'heading1', view: 'h1', title: 'عنوان 1', class: 'ck-heading_heading1' },
					{ model: 'heading2', view: 'h2', title: 'عنوان 2', class: 'ck-heading_heading2' }
				]
			}
		})
				.catch( error => {
					console.error( error );
				});
	});
}
</script>

{{-- FOR SLIDERS --}}
<script>
var slider_images = document.getElementById('slider_images');
var slider_images_before = document.getElementById('slider_images_before');
var slider_images_div = document.getElementById('slider_images_div');
if (slider_images && slider_images_div) {
	slider_images.addEventListener("change", function() {
		if (slider_images.files) {
			let dt = new DataTransfer();
			for(let i=0; i<slider_images.files.length; i++) {
				let f = slider_images.files[i];
				dt.items.add(
					new File(
						[f.slice(0, f.size, f.type)],
						f.name
					)
				);
			}
			var create_div = document.createElement('div');
			create_div.style.position = 'relative';
			create_div.style.margin = '10px';
			var create_label = document.createElement('label');
			var create_input = document.createElement('input');
			create_input.name = "slider_images[]";
			create_input.classList.add("hidden");
			create_input.type = 'file';
			var create_img = document.createElement('img');
			create_img.style.width = '100px';
			create_img.src = URL.createObjectURL(slider_images.files[0]);
			var create_span = document.createElement('span');
			create_span.innerHTML = 'X';
			create_span.classList.add("Programsclose");
			create_span.addEventListener("click", function() {
				this.parentNode.remove();
			});
			
			create_input.files = dt.files;console.log(create_input.files);

			create_label.append(create_input,create_img,create_span);
			create_div.append(create_label);
			slider_images_div.insertBefore(create_div,slider_images_before);
		}
	});
}
var settingsclose = document.querySelectorAll('.Programsclose');
if (settingsclose) {
	settingsclose.forEach( el => {
		el.addEventListener("click", function() {
			this.parentNode.remove();
		});
	});
}
</script>
