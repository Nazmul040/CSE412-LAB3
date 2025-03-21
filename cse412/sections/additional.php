<h2>Additional Information</h2>
<form method="POST" action="" class="section-form" id="additional-form">
    <input type="hidden" name="section" value="additional">
    
    <div class="form-group">
        <label for="certifications">Certifications</label>
        <textarea id="certifications" name="data[certifications]" rows="3" placeholder="List your certifications"><?php echo isset($resume_data['additional']['certifications']) ? htmlspecialchars($resume_data['additional']['certifications']) : ''; ?></textarea>
    </div>
    
    <div class="form-group">
        <label for="languages">Languages</label>
        <textarea id="languages" name="data[languages]" rows="2" placeholder="e.g., English (Native), Spanish (Fluent)"><?php echo isset($resume_data['additional']['languages']) ? htmlspecialchars($resume_data['additional']['languages']) : ''; ?></textarea>
    </div>
    
    <div class="form-group">
        <label for="interests">Interests</label>
        <textarea id="interests" name="data[interests]" rows="2" placeholder="List your interests or hobbies"><?php echo isset($resume_data['additional']['interests']) ? htmlspecialchars($resume_data['additional']['interests']) : ''; ?></textarea>
    </div>
    
    <div class="form-group">
        <label for="references">References</label>
        <textarea id="references" name="data[references]" rows="3" placeholder="List your references or write 'Available upon request'"><?php echo isset($resume_data['additional']['references']) ? htmlspecialchars($resume_data['additional']['references']) : ''; ?></textarea>
    </div>
    
    <div class="form-group">
        <label for="custom_sections">Custom Sections</label>
        <textarea id="custom_sections" name="data[custom_sections]" rows="5" placeholder="Add any additional sections you'd like to include"><?php echo isset($resume_data['additional']['custom_sections']) ? htmlspecialchars($resume_data['additional']['custom_sections']) : ''; ?></textarea>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="view_resume.php?id=<?php echo $resume_id; ?>" class="btn btn-next">Preview Resume</a>
    </div>
</form>