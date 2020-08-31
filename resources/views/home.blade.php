@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Home
@endsection

@section('contentheader_title')
	Home
@endsection
@section('contentheader_description')
@endsection

@section('main-content')
	<div class="card card-solid">
		<div class="card-body">
			<div class="row">
				<div class="col-12 col-sm-4">
					<h3 class="d-inline-block d-sm-none">phpLDAPadmin</h3>
					<img src="img/logo.png" class="logo-image col-12" alt="PLA Logo">
				</div>

				<div class="col-12 col-sm-8">
					<h3 class="mb-1">Welcome to phpLDAPadmin</h3>
					<h4 class="mb-3"><small>{{ config('app.version') }}</small></h4>
					<p>phpLDAPadmin (or PLA for short) is an LDAP data management tool for administrators.</p>
					<p>PLA aims to adhere to the LDAP standards so that it can interact with any LDAP server that implements those standards.</p>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<hr>
					<p>Version 2 is a complete re-write of PLA, leveraging the advancements and modernisation of web tools and methods, libraries since version 1 was released.</p>
					<p>You can support this application by letting us know which LDAP server you use (including version and platform).</p>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('page-scripts')
	@js('https://code.jquery.com/ui/1.12.1/jquery-ui.min.js','jquery-ui')
	@js('https://cdnjs.cloudflare.com/ajax/libs/jquery.fancytree/2.36.1/jquery.fancytree-all.min.js','fancytree-js-all')
	@css('https://cdnjs.cloudflare.com/ajax/libs/jquery.fancytree/2.36.1/skin-xp/ui.fancytree.min.css','fancytree-css')

	<script type="text/javascript">
		function expandChildren(node) {
			if (node.data.autoExpand && !node.isExpanded()) {
				node.setExpanded(true);
			}

			if (node.children && node.children.length > 0) {
				try {
					node.children.forEach(expandChildren);
				} catch (error) {
				}
			}
		}

		$(document).ready(function() {
			// Attach the fancytree widget to an existing <div id="tree"> element
			// and pass the tree options as an argument to the fancytree() function:
			$('#tree').fancytree({
				clickFolderMode: 3,
				extensions: ['glyph'],
				autoCollapse: true, // Automatically collapse all siblings, when a node is expanded.
				autoScroll: true, // Automatically scroll nodes into visible area.
				focusOnSelect: true, // Set focus when node is checked by a mouse click
				click: function(event, data) {
					if (data.targetType == 'title')
						return false;
				},
				init: function(event, data) {
					expandChildren(data.tree.rootNode);
				},
				source: {
					url: "{{ url('api/bases') }}"
				},
				lazyLoad: function(event,data) {
					data.result = {
						url: "{{ url('api/query') }}",
						data: {key: data.node.data.item,depth: 1}
					};

					expandChildren(data.tree.rootNode);
				},
				keydown: function(event, data){
					switch( $.ui.fancytree.eventToString(data.originalEvent) ) {
						case "return":
						case "space":
							data.node.toggleExpanded();
							break;
					}
				}
			});
		});

	</script>
@append
