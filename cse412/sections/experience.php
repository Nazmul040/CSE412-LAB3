<h2>Work Experience</h2>
<form method="POST" action="" class="section-form" id="experience-form">
    <input type="hidden" name="section" value="experience">
    
    <div id="experience-items">
        <?php 
        $experience_items = isset($resume_data['experience']) ? $resume_data['experience'] : [[]];
        foreach ($experience_items as $index => $item): 
        ?>
        <div class="experience-item" data-index="<?php echo $index; ?>">
            <h3>Experience #<?php echo $index + 1; ?></h3>
            
            <div class="form-group">
                <label for="company_<?php echo $index; ?>">Company</label>
                <input type="text" id="company_<?php echo $index; ?>" name="data[<?php echo $index; ?>][company]" value="<?php echo isset($item['company']) ? htmlspecialchars($item['company']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="position_<?php echo $index; ?>">Position</label>
                <input type="text" id="position_<?php echo $index; ?>" name="data[<?php echo $index; ?>][position]" value="<?php echo isset($item['position']) ? htmlspecialchars($item['position']) : ''; ?>" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="start_date_<?php echo $index; ?>">Start Date</label>
                    <input type="month" id="start_date_<?php echo $index; ?>" name="data[<?php echo $index; ?>][start_date]" value="<?php echo isset($item['start_date']) ? htmlspecialchars($item['start_date']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="end_date_<?php echo $index; ?>">End Date</label>
                    <input type="month" id="end_date_<?php echo $index; ?>" name="data[<?php echo $index; ?>][end_date]" value="<?php echo isset($item['end_date']) ? htmlspecialchars($item['end_date']) : ''; ?>">
                    <div class="checkbox-group">
                        <input type="checkbox" id="current_<?php echo $index; ?>" name="data[<?php echo $index; ?>][current]" <?php echo isset($item['current']) && $item['current'] ? 'checked' : ''; ?>>
                        <label for="current_<?php echo $index; ?>">Current Position</label>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="location_<?php echo $index; ?>">Location</label>
                <input type="text" id="location_<?php echo $index; ?>" name="data[<?php echo $index; ?>][location]" value="<?php echo isset($item['location']) ? htmlspecialchars($item['location']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="description_<?php echo $index; ?>">Description</label>
                <textarea id="description_<?php echo $index; ?>" name="data[<?php echo $index; ?>][description]" rows="5"><?php echo isset($item['description']) ? htmlspecialchars($item['description']) : ''; ?></textarea>
                <small>Use bullet points to highlight achievements and responsibilities.</small>
            </div>
            
            <?php if ($index > 0): ?>
            <button type="button" class="btn btn-remove" onclick="removeExperience(<?php echo $index; ?>)">Remove</button>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" class="btn btn-add" onclick="addExperience()">Add Another Experience</button>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="edit_resume.php?id=<?php echo $resume_id; ?>&section=skills" class="btn btn-next">Next: Skills</a>
    </div>
</form>

<script>
let experienceCount = <?php echo count($experience_items); ?>;

function addExperience() {
    const index = experienceCount;
    const template = `
        <div class="experience-item" data-index="${index}">
            <h3>Experience #${index + 1}</h3>
            
            <div class="form-group">
                <label for="company_${index}">Company</label>
                <input type="text" id="company_${index}" name="data[${index}][company]" required>
            </div>
            
            <div class="form-group">
                <label for="position_${index}">Position</label>
                <input type="text" id="position_${index}" name="data[${index}][position]" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="start_date_${index}">Start Date</label>
                    <input type="month" id="start_date_${index}" name="data[${index}][start_date]">
                </div>
                
                <div class="form-group">
                    <label for="end_date_${index}">End Date</label>
                    <input type="month" id="end_date_${index}" name="data[${index}][end_date]">
                    <div class="checkbox-group">
                        <input type="checkbox" id="current_${index}" name="data[${index}][current]">
                        <label for="current_${index}">Current Position</label>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="location_${index}">Location</label>
                <input type="text" id="location_${index}" name="data[${index}][location]">
            </div>
            
            <div class="form-group">
                <label for="description_${index}">Description</label>
                <textarea id="description_${index}" name="data[${index}][description]" rows="5"></textarea>
                <small>Use bullet points to highlight achievements and responsibilities.</small>
            </div>
            
            <button type="button" class="btn btn-remove" onclick="removeExperience(${index})">Remove</button>
        </div>
    `;
    
    document.getElementById('experience-items').insertAdjacentHTML('beforeend', template);
    experienceCount++;
}

function remove