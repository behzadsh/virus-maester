<div class="tab-pane fade" id="url">
    <div class="form-info">Enter the url address you want to scan, and press "Scan it!" button.</div>
    <div class="row inside-panel">
        <div class="control-group" id="fields">
            <div class="controls">
                <form action="{{ route('url') }}" method="post">
                    <div class="entry input-group">
                        <input class="form-control input-lg" name="url" type="text" placeholder="http://www.example.com" />
                    	<span class="input-group-btn">
                            <input class="btn btn-lg btn-primary" type="submit" value="Scan it!">
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>