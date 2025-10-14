class MyUploadAdapter {
    constructor(loader, csrf) {
        // The file loader instance to use during the upload.
        this.loader = loader;
        this.csrf = csrf;
    }

    // Starts the upload process.
    upload() {
        var loader = this.loader;
        var csrf = this.csrf;

        return new Promise(function (resolve, reject) {
            const xhr = new XMLHttpRequest();

            // Note that your request may look different. It is up to you and your editor
            // integration to choose the right communication channel. This example uses
            // a POST request with JSON as a data structure but your configuration
            // could be different.
            xhr.open("POST", UploadURL, true);
            xhr.responseType = "json";

            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            xhr.addEventListener("load", function () {
                const response = xhr.response;
                // This example assumes the XHR server's "response" object will come with
                // an "error" which has its own "message" that can be passed to reject()
                // in the upload promise.
                //
                // Your integration may handle upload errors in a different way so make sure
                // it is done properly. The reject() function must be called when the upload fails.
                if (!response || response.error) {
                    return reject(
                        response && response.error
                            ? response.error.message
                            : genericErrorText
                    );
                }

                // If the upload is successful, resolve the upload promise with an object containing
                // at least the "default" URL, pointing to the image on the server.
                // This URL will be used to display the image in the content. Learn more in the
                // UploadAdapter#upload documentation.

                resolve({
                    default: response.url,
                });
            });

            const data = new FormData();
            data.append("upload", loader.file);

            // Important note: This is the right place to implement security mechanisms
            // like authentication and CSRF protection. For instance, you can use
            // XMLHttpRequest.setRequestHeader() to set the request headers containing
            // the CSRF token generated earlier by your application.

            // Send the request.
            xhr.send(data);
        });
    }

    // Aborts the upload process.
    abort() {
        if (this.xhr) {
            this.xhr.abort();
        }
    }
}
