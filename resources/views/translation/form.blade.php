<div class="row">
    <div class="col-md-6 form-group">
        <label for="">Language</label>
        <select name="lang" class="form-control @error('lang') is-invalid @enderror select2" id="lang">
            <option value="">Select</option>
            @foreach ($langs as $lang)
                <option value="{{ $lang->id }}"
                    {{ old('lang') == $lang->id ? 'selected' : ($translationText?->lang == $lang->id ? 'selected' : '') }}>
                    {{ $lang->name }}</option>
            @endforeach
        </select>
        @error('lang')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 form-group">
        <label for="">Translation For</label>
        <select name="translation_type" class="form-control @error('translation_type') is-invalid @enderror select2"
            id="translation_type">
            <option value="">Select</option>
            @foreach ($translationTypes as $index => $translationType)
                <option value="{{ $index }}"
                    {{ old('translation_type') == $index ? 'selected' : ($translationText?->translation_type == $index ? 'selected' : '') }}>
                    {{ $translationType }}</option>
            @endforeach
        </select>
        @error('translation_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-12 form-group">
        <label for="">Translation Content</label>
        <div class="clear-both">
            <div class="content_div" id="content_div">
            </div>
        </div>
        <div style="clear: both;"></div>
        @error('content')
            <div class="fv-plugins-message-container">
                <div data-field="content" data-validator="stringLength" class="fv-help-block">
                    {{ $message }}
                </div>
            </div>
        @enderror
        <textarea name="content" id="content-textarea" class="d-none">

        </textarea>
    </div>

</div>
