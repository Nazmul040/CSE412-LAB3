<div class="resume-template default-template">
    <!-- Header Section -->
    <div class="resume-header">
        <?php if (isset($resume_data['personal'])): ?>
            <h1 class="resume-name"><?php echo htmlspecialchars($resume_data['personal']['fullname'] ?? ''); ?></h1>
            
            <div class="resume-contact">
                <?php if (!empty($resume_data['personal']['email'])): ?>
                    <div class="contact-item">
                        <span class="contact-icon">✉</span>
                        <span class="contact-text"><?php echo htmlspecialchars($resume_data['personal']['email']); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($resume_data['personal']['phone'])): ?>
                    <div class="contact-item">
                        <span class="contact-icon">☏</span>
                        <span class="contact-text"><?php echo htmlspecialchars($resume_data['personal']['phone']); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($resume_data['personal']['address'])): ?>
                    <div class="contact-item">
                        <span class="contact-icon">⌂</span>
                        <span class="contact-text"><?php echo htmlspecialchars($resume_data['personal']['address']); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($resume_data['personal']['website'])): ?>
                    <div class="contact-item">
                        <span class="contact-icon">🔗</span>
                        <span class="contact-text"><?php echo htmlspecialchars($resume_data['personal']['website']); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($resume_data['personal']['linkedin'])): ?>
                    <div class="contact-item">
                        <span class="contact-icon">in</span>
                        <span class="contact-text"><?php echo htmlspecialchars($resume_data['personal']['linkedin']); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($resume_data['personal']['summary'])): ?>
                <div class="resume-summary">
                    <h2>Professional Summary</h2>
                    <p><?php echo nl2br(htmlspecialchars($resume_data['personal']['summary'])); ?></p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    
    <!-- Education Section -->
    <?php if (isset($resume_data['education']) && !empty($resume_data['education'][0]['institution'])): ?>
        <div class="resume-section">
            <h2>Education</h2>
            <?php foreach ($resume_data['education'] as $education): ?>
                <?php if (!empty($education['institution'])): ?>
                    <div class="resume-item">
                        <div class="item-header">
                            <h3><?php echo htmlspecialchars($education['degree']); ?></h3>
                            <div class="item-subheader">
                                <span class="item-title"><?php echo htmlspecialchars($education['institution']); ?></span>
                                <?php if (!empty($education['location'])): ?>
                                    <span class="item-location"><?php echo htmlspecialchars($education['location']); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($education['start_date']) || !empty($education['end_date'])): ?>
                                <div class="item-date">
                                    <?php 
                                    $start = !empty($education['start_date']) ? date('M Y', strtotime($education['start_date'])) : '';
                                    $end = !empty($education['end_date']) ? date('M Y', strtotime($education['end_date'])) : 'Present';
                                    echo $start . ' - ' . $end;
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($education['description'])): ?>
                            <div class="item-description">
                                <p><?php echo nl2br(htmlspecialchars($education['description'])); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <!-- Experience Section -->
    <?php if (isset($resume_data['experience']) && !empty($resume_data['experience'][0]['company'])): ?>
        <div class="resume-section">
            <h2>Work Experience</h2>
            <?php foreach ($resume_data['experience'] as $experience): ?>
                <?php if (!empty($experience['company'])): ?>
                    <div class="resume-item">
                        <div class="item-header">
                            <h3><?php echo htmlspecialchars($experience['position']); ?></h3>
                            <div class="item-subheader">
                                <span class="item-title"><?php echo htmlspecialchars($experience['company']); ?></span>
                                <?php if (!empty($experience['location'])): ?>
                                    <span class="item-location"><?php echo htmlspecialchars($experience['location']); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($experience['start_date']) || !empty($experience['end_date']) || !empty($experience['current'])): ?>
                                <div class="item-date">
                                    <?php 
                                    $start = !empty($experience['start_date']) ? date('M Y', strtotime($experience['start_date'])) : '';
                                    $end = !empty($experience['current']) ? 'Present' : (!empty($experience['end_date']) ? date('M Y', strtotime($experience['end_date'])) : '');
                                    echo $start . ' - ' . $end;
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($experience['description'])): ?>
                            <div class="item-description">
                                <?php echo nl2br(htmlspecialchars($experience['description'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <!-- Skills Section -->
    <?php if (isset($resume_data['skills']) && !empty($resume_data['skills'][0]['skills'])): ?>
        <div class="resume-section">
            <h2>Skills</h2>
            <div class="skills-container">
                <?php foreach ($resume_data['skills'] as $skillCategory): ?>
                    <?php if (!empty($skillCategory['skills'])): ?>
                        <div class="skill-group">
                            <?php if (!empty($skillCategory['category'])): ?>
                                <h3><?php echo htmlspecialchars($skillCategory['category']); ?></h3>
                            <?php endif; ?>
                            <div class="skill-list">
                                <?php 
                                $skills = explode(',', $skillCategory['skills']);
                                foreach ($skills as $skill): 
                                ?>
                                    <span class="skill-item"><?php echo htmlspecialchars(trim($skill)); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Projects Section -->
    <?php if (isset($resume_data['projects']) && !empty($resume_data['projects'][0]['title'])): ?>
        <div class="resume-section">
            <h2>Projects</h2>
            <?php foreach ($resume_data['projects'] as $project): ?>
                <?php if (!empty($project['title'])): ?>
                    <div class="resume-item">
                        <div class="item-header">
                            <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                            <?php if (!empty($project['technologies'])): ?>
                                <div class="item-subheader">
                                    <span class="item-technologies"><?php echo htmlspecialchars($project['technologies']); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($project['start_date']) || !empty($project['end_date'])): ?>
                                <div class="item-date">
                                    <?php 
                                    $start = !empty($project['start_date']) ? date('M Y', strtotime($project['start_date'])) : '';
                                    $end = !empty($project['end_date']) ? date('M Y', strtotime($project['end_date'])) : 'Present';
                                    echo $start . ' - ' . $end;
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($project['description'])): ?>
                            <div class="item-description">
                                <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($project['url'])): ?>
                            <div class="project-url">
                                <a href="<?php echo htmlspecialchars($project['url']); ?>" target="_blank">View Project</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <!-- Additional Information Section -->
    <?php if (isset($resume_data['additional'])): ?>
        <?php if (!empty($resume_data['additional']['certifications'])): ?>
            <div class="resume-section">
                <h2>Certifications</h2>
                <div class="additional-content">
                    <?php echo nl2br(htmlspecialchars($resume_data['additional']['certifications'])); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($resume_data['additional']['languages'])): ?>
            <div class="resume-section">
                <h2>Languages</h2>
                <div class="additional-content">
                    <?php echo nl2br(htmlspecialchars($resume_data['additional']['languages'])); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($resume_data['additional']['interests'])): ?>
            <div class="resume-section">
                <h2>Interests</h2>
                <div class="additional-content">
                    <?php echo nl2br(htmlspecialchars($resume_data['additional']['interests'])); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($resume_data['additional']['references'])): ?>
            <div class="resume-section">
                <h2>References</h2>
                <div class="additional-content">
                    <?php echo nl2br(htmlspecialchars($resume_data['additional']['references'])); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($resume_data['additional']['custom_sections'])): ?>
            <div class="resume-section">
                <h2>Additional Information</h2>
                <div class="additional-content">
                    <?php echo nl2br(htmlspecialchars($resume_data['additional']['custom_sections'])); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>