
<h2>Education</h2>
<form method="POST" action="" class="section-form" id="education-form">
    <input type="hidden" name="section" value="education">
    
    <div id="education-items">
        <?php 
        $education_items = isset($resume_data['education']) ? $resume_data['education'] : [[]];
        foreach ($education_items as $index => $item): 
        ?>
        <div class="education-item" data-index="<?php echo $index; ?>">
            <h3>Education #<?php echo $index + 1; ?></h3>
            
            <div class="form-group">
                <label for="institution_<?php echo $index; ?>">Institution</label>
                <input type="text" id="institution_<?php echo $index; ?>" name="data[<?php echo $index; ?>][institution]" value="<?php echo isset($item['institution']) ? htmlspecialchars($item['institution']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="degree_<?php echo $index; ?>">Degree</label>
                <input type="text" id="degree_<?php echo $index; ?>" name="data[<?php echo $index; ?>][degree]" value="<?php echo isset($item['degree']) ? htmlspecialchars($item['degree']) : ''; ?>" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="start_date_<?php echo $index; ?>">Start Date</label>
                    <input type="month" id="start_date_<?php echo $index; ?>" name="data[<?php echo $index; ?>][start_date]" value="<?php echo isset($item['start_date']) ? htmlspecialchars($item['start_date']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="end_date_<?php echo $index; ?>">End Date</label>
                    <input type="month" id="end_date_<?php echo $index; ?>" name="data[<?php echo $index; ?>][end_date]" value="<?php echo isset($item['end_date']) ? htmlspecialchars($item['end_date']) : ''; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="location_<?php echo $index; ?>">Location</label>
                <input type="text" id="location_<?php echo $index; ?>" name="data[<?php echo $index; ?>][location]" value="<?php echo isset($item['location']) ? htmlspecialchars($item['location']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="description_<?php echo $index; ?>">Description</label>
                <textarea id="description_<?php echo $index; ?>" name="data[<?php echo $index; ?>][description]" rows="3"><?php echo isset($item['description']) ? htmlspecialchars($item['description']) : ''; ?></textarea>
            </div>
            
            <?php if ($index > 0): ?>
            <button type="button" class="btn btn-remove" onclick="removeEducation(<?php echo $index; ?>)">Remove</button>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" class="btn btn-add" onclick="addEducation()">Add Another Education</button>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="edit_resume.php?id=<?php echo $resume_id; ?>&section=experience" class="btn btn-next">Next: Work Experience</a>
    </div>
</form>

<script>
let educationCount = <?php echo count($education_items); ?>;

function addEducation() {
    const index = educationCount;
    const template = `
        <div class="education-item" data-index="${index}">
            <h3>Education #${index + 1}</h3>
            
            <div class="form-group">
                <label for="institution_${index}">Institution</label>
                <input type="text" id="institution_${index}" name="data[${index}][institution]" required>
            </div>
            
            <div class="form-group">
                <label for="degree_${index}">Degree</label>
                <input type="text" id="degree_${index}" name="data[${index}][degree]" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="start_date_${index}">Start Date</label>
                    <input type="month" id="start_date_${index}" name="data[${index}][start_date]">
                </div>
                
                <div class="form-group">
                    <label for="end_date_${index}">End Date</label>
                    <input type="month" id="end_date_${index}" name="data[${index}][end_date]">
                </div>
            </div>
            
            <div class="form-group">
                <label for="location_${index}">Location</label>
                <input type="text" id="location_${index}" name="data[${index}][location]">
            </div>
            
            <div class="form-group">
                <label for="description_${index}">Description</label>
                <textarea id="description_${index}" name="data[${index}][description]" rows="3"></textarea>
            </div>
            
            <button type="button" class="btn btn-remove" onclick="removeEducation(${index})">Remove</button>
        </div>
    `;
    
    document.getElementById('education-items').insertAdjacentHTML('beforeend', template);
    educationCount++;
}

function removeEducation(index) {
    const item = document.querySelector(`.education-item[data-index="${index}"]`);
    item.remove();
}
</script>