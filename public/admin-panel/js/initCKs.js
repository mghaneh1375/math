function initCK(csrf) {
    DecoupledEditor.create(document.querySelector("#desc"), {
        alignment: {
            options: ["left", "right", "justify", "center"],
        },
    }).then(function (editor) {
        const toolbarContainer = document.querySelector("#toolbar-container");
        toolbarContainer.appendChild(editor.ui.view.toolbar.element);
        editor.execute("alignment", { value: "justify" });
        editor.plugins.get("FileRepository").createUploadAdapter = function (
            loader
        ) {
            return new MyUploadAdapter(loader, csrf);
        };
    });
}
