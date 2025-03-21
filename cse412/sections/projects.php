<h2>Projects</h2>
<form method="POST" action="" class="section-form" id="projects-form">
    <input type="hidden" name="section" value="projects">
    
    <div id="project-items">
        <?php 
        $project_items = isset($resume_data['projects']) ? $resume_data['projects'] : [[]];
        foreach ($project_items as $index => $item): 
        ?>
        <div class="project-item" data-index="<?php echo $index; ?>">
            <h3>Project #<?php echo $index + 1; ?></h3>
            
            <div class="form-group">
                <label for="title_<?php echo $index; ?>">Project Title</label>
                <input type="text" id="title_<?php echo $index; ?>" name="data[<?php echo $index; ?>][title]" value="<?php echo isset($item['title']) ? htmlspecialchars($item['title']) : ''; ?>" required>
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
                <label for="technologies_<?php echo $index; ?>">Technologies Used</label>
                <input type="text" id="technologies_<?php echo $index; ?>" name="data[<?php echo $index; ?>][technologies]" value="<?php echo isset($item['technologies']) ? htmlspecialchars($item['technologies']) : ''; ?>" placeholder="e.g., React, Node.js, MongoDB">
            </div>
            
            <div class="form-group">
                <label for="url_<?php echo $index; ?>">Project URL</label>
                <input type="url" id="url_<?php echo $index; ?>" name="data[<?php echo $index; ?>][url]" value="<?php echo isset($item['url']) ? htmlspecialchars($item['url']) : ''; ?>" placeholder="https://...">
            </div>
            
            <div class="form-group">
                <label for="description_<?php echo $index; ?>">Description</label>
                <textarea id="description_<?php echo $index; ?>" name="data[<?php echo $index; ?>][description]" rows="4"><?php echo isset($item['description']) ? htmlspecialchars($item['description']) : ''; ?></textarea>
                <small>Describe the project, your role, and key achievements</small>
            </div>
            
            <?php if ($index > 0): ?>
            <button type="button" class="btn btn-remove" onclick="removeProject(<?php echo $index; ?>)">Remove</button>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" class="btn btn-add" onclick="addProject()">Add Another Project</button>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="edit_resume.php?id=<?php echo $resume_id; ?>&section=additional" class="btn btn-next">Next: Additional Information</a>
    </div>
</form>

<script>
let projectCount = <?php echo count($project_items); ?>;

function addProject() {
    const index = projectCount;
    const template = `
        <div class="project-item" data-index="${index}">
            <h3>Project #${index + 1}</h3>
            
            <div class="form-group">
                <label for="title_${index}">Project Title</label>
                <input type="text" id="title_${index}" name="data[${index}][title]" required>
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
                <label for="technologies_${index}">Technologies Used</label>
                <input type="text" id="technologies_${index}" name="data[${index}][technologies]" placeholder="e.g., React, Node.js, MongoDB">
            </div>
            
            <div class="form-group">
                <label for="url_${index}">Project URL</label>
                <input type="url" id="url_${index}" name="data[${index}][url]" placeholder="https://...">
            </div>
            
            <div class="form-group">
                <label for="description_${index}">Description</label>
                <textarea id="description_${index}" name="data[${index}][description]" rows="4"></textarea>
                <small>Describe the project, your role, and key achievements</small>
            </div>
            
            <button type="button" class="btn btn-remove" onclick="removeProject(${index})">Remove</button>
        </div>
    `;
    
    document.getElementById('project-items').insertAdjacentHTML('beforeend', template);
    projectCount++;
}

function removeProject(index) {
    const item = document.querySelector(`.project-item[data-index="${index}"]`);
    item.remove();
}
</script>