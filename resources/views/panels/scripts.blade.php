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
	background-color: red;
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
		CDiv2.style.backgroundColor = '#7367f0';
		
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
