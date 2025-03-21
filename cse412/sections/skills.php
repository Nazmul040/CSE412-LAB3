<h2>Skills</h2>
<form method="POST" action="" class="section-form" id="skills-form">
    <input type="hidden" name="section" value="skills">
    
    <div class="form-group">
        <label for="skill_categories">Skill Categories</label>
        <p class="form-hint">Add different categories of skills (e.g., Programming Languages, Tools, Soft Skills)</p>
        
        <div id="skill-categories">
            <?php 
            $skills = isset($resume_data['skills']) ? $resume_data['skills'] : [['category' => '', 'skills' => '']];
            foreach ($skills as $index => $category): 
            ?>
            <div class="skill-category" data-index="<?php echo $index; ?>">
                <div class="form-row">
                    <div class="form-group">
                        <label for="category_<?php echo $index; ?>">Category Name</label>
                        <input type="text" id="category_<?php echo $index; ?>" name="data[<?php echo $index; ?>][category]" value="<?php echo htmlspecialchars($category['category']); ?>" placeholder="e.g., Programming Languages">
                    </div>
                    
                    <div class="form-group flex-grow">
                        <label for="skills_<?php echo $index; ?>">Skills</label>
                        <textarea id="skills_<?php echo $index; ?>" name="data[<?php echo $index; ?>][skills]" rows="2" placeholder="e.g., JavaScript, Python, HTML, CSS"><?php echo htmlspecialchars($category['skills']); ?></textarea>
                        <small>Separate skills with commas</small>
                    </div>
                </div>
                
                <?php if ($index > 0): ?>
                <button type="button" class="btn btn-remove" onclick="removeSkillCategory(<?php echo $index; ?>)">Remove</button>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        
        <button type="button" class="btn btn-add" onclick="addSkillCategory()">Add Another Skill Category</button>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="edit_resume.php?id=<?php echo $resume_id; ?>&section=projects" class="btn btn-next">Next: Projects</a>
    </div>
</form>

<script>
let skillCategoryCount = <?php echo count($skills); ?>;

function addSkillCategory() {
    const index = skillCategoryCount;
    const template = `
        <div class="skill-category" data-index="${index}">
            <div class="form-row">
                <div class="form-group">
                    <label for="category_${index}">Category Name</label>
                    <input type="text" id="category_${index}" name="data[${index}][category]" placeholder="e.g., Programming Languages">
                </div>
                
                <div class="form-group flex-grow">
                    <label for="skills_${index}">Skills</label>
                    <textarea id="skills_${index}" name="data[${index}][skills]" rows="2" placeholder="e.g., JavaScript, Python, HTML, CSS"></textarea>
                    <small>Separate skills with commas</small>
                </div>
            </div>
            
            <button type="button" class="btn btn-remove" onclick="removeSkillCategory(${index})">Remove</button>
        </div>
    `;
    
    document.getElementById('skill-categories').insertAdjacentHTML('beforeend', template);
    skillCategoryCount++;
}

function removeSkillCategory(index) {
    const item = document.querySelector(`.skill-category[data-index="${index}"]`);
    item.remove();
}
</script>