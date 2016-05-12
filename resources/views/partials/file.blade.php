<div class="tab-pane fade in active" id="file">
    <div class="form-info">Select the file you want to scan, and press "Scan" button.</div>
    <div class="row inside-panel">
        <form action="{{ route('file') }}" method="post" enctype="multipart/form-data">
            <div class="input-group scanning-file">
                <input type="text" class="form-control scanning-file-filename"
                       disabled="disabled" title="name-preview">
                <span class="input-group-btn">
                    <button type="button" class="btn  btn-warning scanning-file-clear"
                            style="display:none;">
                        <span class="glyphicon glyphicon-remove"></span> Clear
                    </button>
                    <div class="btn btn-info scanning-file-input">
                        <span class="glyphicon glyphicon-folder-open"></span>
                        <span class="scanning-file-input-title">Browse</span>
                        <input class="" type="file" name="file" required>
                    </div>
                </span>
            </div>
            <div class="notice">Maximum file size: 128MB</div>
            <div class="submit-container">
                <input class="btn btn-lg btn-primary btn-scan" type="submit" value="Scan!">
            </div>
        </form>
    </div>
</div>
