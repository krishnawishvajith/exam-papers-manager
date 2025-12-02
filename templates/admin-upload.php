<div class="wrap epm-admin-wrap">
    <div class="epm-header">
        <h1 class="epm-title">
            <span class="dashicons dashicons-upload"></span>
            Upload Exam Papers
        </h1>
        <p class="epm-subtitle">Upload and manage exam papers, mark schemes, and related documents</p>
    </div>

    <div class="epm-upload-container">
        <form id="exam-paper-upload-form" class="epm-upload-form" enctype="multipart/form-data">
            <?php wp_nonce_field('epm_admin_nonce', 'epm_nonce'); ?>

            <div class="epm-form-grid">
                <div class="epm-form-group">
                    <label for="title" class="epm-label">Document Title</label>
                    <input type="text" id="title" name="title" class="epm-input" placeholder="e.g., English Paper - Question paper: Paper 2 Social Context" required>
                </div>

                <div class="epm-form-group">
                    <label for="qualification" class="epm-label">Qualification</label>
                    <select id="qualification" name="qualification" class="epm-select" required>
                        <option value="">Select Qualification</option>
                        <option value="AS Psychology">AS Psychology</option>
                        <option value="A-Level Psychology">A-Level Psychology</option>
                    </select>
                </div>

                <div class="epm-form-group">
                    <label for="year_of_paper" class="epm-label">Year of past paper</label>
                    <select id="year_of_paper" name="year_of_paper" class="epm-select" required>
                        <option value="">Select Year</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                        <option value="2019">2019</option>
                        <option value="2018">2018</option>
                        <option value="2017">2017</option>
                        <option value="2016">2016</option>
                        <option value="2015">2015</option>
                        <option value="old">Old</option>
                    </select>
                </div>

                <div class="epm-form-group">
                    <label for="resource_type" class="epm-label">Resource type</label>
                    <select id="resource_type" name="resource_type" class="epm-select" required>
                        <option value="">Select Type</option>
                        <option value="Question paper">Question paper</option>
                        <option value="Mark schemes">Mark schemes</option>
                        <option value="Examiners report">Examiners report</option>
                        <option value="Sample material">Sample material</option>
                        <option value="Question papers">Question papers</option>
                    </select>
                </div>

                <!-- PRIORITY SECTION - NEW SYSTEM FOR UP TO 10 PAPERS -->
                <div class="epm-form-group" style="grid-column: 1 / -1;">
                    <label class="epm-label">Paper Priority Order (Optional)</label>
                    <small style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem; display: block;">
                        The newly uploaded paper will appear at the top. Select existing papers below to set their priority order (2nd, 3rd, 4th, etc.)
                    </small>
                    
                    <?php
                    global $wpdb;
                    $table_name = $wpdb->prefix . 'exam_papers';
                    $existing_papers = $wpdb->get_results("SELECT id, title FROM $table_name ORDER BY upload_date DESC");
                    ?>

                    <div id="priority-fields-container">
                        <?php for ($i = 2; $i <= 11; $i++): ?>
                        <div class="epm-priority-field" id="priority-field-<?php echo $i; ?>" style="margin-bottom: 0.75rem; <?php echo $i > 2 ? 'display: none;' : ''; ?>">
                            <label for="priority_paper_<?php echo $i; ?>" style="font-size: 0.875rem; color: #374151; margin-bottom: 0.25rem; display: block;">
                                Position <?php echo $i; ?>:
                            </label>
                            <select id="priority_paper_<?php echo $i; ?>" name="priority_papers[]" class="epm-select priority-select" data-position="<?php echo $i; ?>" style="width: 100%;">
                                <option value="">-- No Prioritisation --</option>
                                <?php
                                if ($existing_papers) {
                                    foreach ($existing_papers as $existing_paper) {
                                        echo '<option value="' . esc_attr($existing_paper->id) . '">' . esc_html($existing_paper->title) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="epm-form-group epm-file-upload-group">
                    <label for="exam_file" class="epm-label">Upload Document</label>
                    <div class="epm-file-upload-wrapper">
                        <input type="file" id="exam_file" name="exam_file" class="epm-file-input" accept=".pdf,.ppt,.pptx,.doc,.docx" required>
                        <label for="exam_file" class="epm-file-label">
                            <span class="dashicons dashicons-cloud-upload"></span>
                            <span class="epm-file-text">Choose File (PDF, PPT, DOC)</span>
                        </label>
                        <div class="epm-file-info"></div>
                    </div>
                </div>
            </div>

            <div class="epm-form-actions">
                <button type="submit" class="epm-btn epm-btn-primary">
                    <span class="dashicons dashicons-upload"></span>
                    Upload Exam Paper
                </button>
                <button type="reset" class="epm-btn epm-btn-secondary">
                    <span class="dashicons dashicons-dismiss"></span>
                    Clear Form
                </button>
            </div>
        </form>
    </div>

    <div class="epm-upload-status" id="upload-status" style="display: none;">
        <div class="epm-status-content">
            <span class="epm-status-icon"></span>
            <span class="epm-status-message"></span>
        </div>
    </div>

    <!-- Recently Uploaded Papers -->
    <div class="epm-recent-uploads">
        <h2 class="epm-section-title">
            <span class="dashicons dashicons-clock"></span>
            Recently Uploaded Papers
        </h2>
        <div id="recent-papers-list" class="epm-papers-list">
            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . 'exam_papers';
            $recent_papers = $wpdb->get_results("SELECT * FROM $table_name ORDER BY priority_order DESC, upload_date DESC LIMIT 5");

            if ($recent_papers) {
                foreach ($recent_papers as $paper) {
                    echo '<div class="epm-paper-item">';
                    echo '<div class="epm-paper-icon">';
                    echo '<span class="dashicons dashicons-media-document"></span>';
                    echo '</div>';
                    echo '<div class="epm-paper-details">';
                    echo '<h3>' . esc_html($paper->title) . '</h3>';
                    echo '<p>' . esc_html($paper->qualification) . ' • ' . esc_html($paper->year_of_paper) . ' • ' . esc_html($paper->resource_type) . '</p>';
                    echo '</div>';
                    echo '<div class="epm-paper-actions">';
                    echo '<a href="' . esc_url($paper->file_url) . '" target="_blank" class="epm-btn epm-btn-small">View</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="epm-no-papers">No papers uploaded yet.</p>';
            }
            ?>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Priority fields cascading logic
    $('.priority-select').on('change', function() {
        const currentPosition = parseInt($(this).data('position'));
        const selectedValue = $(this).val();
        
        // If a paper is selected, show the next field
        if (selectedValue) {
            const nextField = $('#priority-field-' + (currentPosition + 1));
            if (nextField.length && currentPosition < 11) {
                nextField.slideDown(300);
            }
            
            // Remove selected paper from all subsequent dropdowns
            updateAvailablePapers();
        } else {
            // If cleared, hide all subsequent fields and clear their values
            for (let i = currentPosition + 1; i <= 11; i++) {
                $('#priority-field-' + i).slideUp(300);
                $('#priority_paper_' + i).val('');
            }
            updateAvailablePapers();
        }
    });
    
    // Update available papers in dropdowns based on selections
    function updateAvailablePapers() {
        const selectedPapers = [];
        
        // Collect all selected paper IDs
        $('.priority-select').each(function() {
            const val = $(this).val();
            if (val) {
                selectedPapers.push(val);
            }
        });
        
        // Update each dropdown
        $('.priority-select').each(function() {
            const currentSelect = $(this);
            const currentValue = currentSelect.val();
            
            // Re-enable all options first
            currentSelect.find('option').prop('disabled', false);
            
            // Disable already selected papers (except current selection)
            selectedPapers.forEach(function(paperId) {
                if (paperId !== currentValue) {
                    currentSelect.find('option[value="' + paperId + '"]').prop('disabled', true);
                }
            });
        });
    }
    
    // Reset priority fields on form reset
    $('button[type="reset"]').on('click', function() {
        setTimeout(function() {
            // Hide all priority fields except the first one
            for (let i = 3; i <= 11; i++) {
                $('#priority-field-' + i).hide();
            }
            // Clear all priority selections
            $('.priority-select').val('');
            updateAvailablePapers();
        }, 10);
    });
});
</script>

<style>
.epm-priority-field select:disabled {
    background-color: #f3f4f6;
    cursor: not-allowed;
}

.epm-priority-field select option:disabled {
    color: #9ca3af;
}

.epm-priority-field {
    transition: all 0.3s ease;
}
</style>