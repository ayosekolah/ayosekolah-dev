CKEDITOR.editorConfig = function (config) {

    config.language = 'en';
    config.extraPlugins = 'ckeditor_wiris';

    config.toolbar = 'custom';
    config.toolbar_custom = [{
            name: 'insert',
            items: ['SpecialChar']
        },
        {
            name: 'tools',
            items: ['Maximize']
        },
        {
            name: 'document',
            groups: ['mode', 'document', 'doctools'],
            items: ['Source']
        },
        {
            name: 'others',
            items: ['-']
        },
        {
            name: 'basicstyles',
            groups: ['basicstyles', 'cleanup'],
            items: ['Bold', 'Italic', 'Subscript', 'Superscript', '-', 'CopyFormatting', '-', 'RemoveFormat']
        },
        {
            name: 'wiris',
            items: ['ckeditor_wiris_formulaEditor', 'ckeditor_wiris_formulaEditorChemistry', 'ChemType']
        }
    ];
}
