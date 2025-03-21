<h2>Personal Information</h2>
<form method="POST" action="" class="section-form" id="personal-form">
    <input type="hidden" name="section" value="personal">
    
    <div class="form-group">
        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="data[fullname]" value="<?php echo isset($resume_data['personal']['fullname']) ? htmlspecialchars($resume_data['personal']['fullname']) : ''; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="data[email]" value="<?php echo isset($resume_data['personal']['email']) ? htmlspecialchars($resume_data['personal']['email']) : ''; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="tel" id="phone" name="data[phone]" value="<?php echo isset($resume_data['personal']['phone']) ? htmlspecialchars($resume_data['personal']['phone']) : ''; ?>">
    </div>
    
    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" id="address" name="data[address]" value="<?php echo isset($resume_data['personal']['address']) ? htmlspecialchars($resume_data['personal']['address']) : ''; ?>">
    </div>
    
    <div class="form-group">
        <label for="website">Website/Portfolio</label>
        <input type="url" id="website" name="data[website]" value="<?php echo isset($resume_data['personal']['website']) ? htmlspecialchars($resume_data['personal']['website']) : ''; ?>">
    </div>
    
    <div class="form-group">
        <label for="linkedin">LinkedIn</label>
        <input type="url" id="linkedin" name="data[linkedin]" value="<?php echo isset($resume_data['personal']['linkedin']) ? htmlspecialchars($resume_data['personal']['linkedin']) : ''; ?>">
    </div>
    
    <div class="form-group">
        <label for="summary">Professional Summary</label>
        <textarea id="summary" name="data[summary]" rows="5"><?php echo isset($resume_data['personal']['summary']) ? htmlspecialchars($resume_data['personal']['summary']) : ''; ?></textarea>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="edit_resume.php?id=<?php echo $resume_id; ?>&section=education" class="btn btn-next">Next: Education</a>
    </div>
</form>