!function(){if("undefined"!=typeof wp){var e=wp.media.view.AttachmentFilters.extend({id:"media-attachment-taxonomy-filter",createFilters:function(){var e={};_.each(MediaLibraryTaxonomyFilterData.terms||{},function(t,o){e[o]={text:t.name,props:{collection:t.slug}}}),e.all={text:"All collections",props:{collection:""},priority:10},this.filters=e}}),t=wp.media.view.AttachmentsBrowser;wp.media.view.AttachmentsBrowser=wp.media.view.AttachmentsBrowser.extend({createToolbar:function(){t.prototype.createToolbar.call(this),this.toolbar.set("MediaLibraryTaxonomyFilter",new e({controller:this.controller,model:this.collection.props,priority:-75}).render())}})}}();