<div class="epm-paper-result">
    <div class="epm-paper-icon">
        <div class="epm-file-type-badge epm-pdf-badge">
            <?php echo strtoupper($paper->file_type); ?>
        </div>
        <span class="epm-document-icon">📄</span>
    </div>
    
    <div class="epm-paper-content">
        <h3 class="epm-paper-title"><?php echo esc_html($paper->title); ?></h3>
        <div class="epm-paper-meta">
            <span class="epm-meta-item">
                <span class="epm-meta-icon">🏫</span>
                <?php echo esc_html($paper->qualification); ?>
            </span>
            <span class="epm-meta-separator">•</span>
            <span class="epm-meta-item">
                <span class="epm-meta-icon">📋</span>
                <?php echo esc_html($paper->resource_type); ?>
            </span>
        </div>
        <div class="epm-paper-year"><?php echo esc_html($paper->year_of_paper); ?></div>
    </div>
    
    <div class="epm-paper-actions">
        <a href="<?php echo esc_url($paper->file_url); ?>" target="_blank" class="epm-btn epm-btn-view">
            <span class="epm-btn-icon">👁️</span>
            View
        </a>
        <a href="<?php echo esc_url($paper->file_url); ?>" download class="epm-btn epm-btn-download">
            <span class="epm-btn-icon">💾</span>
            Download
        </a>
    </div>
</div>