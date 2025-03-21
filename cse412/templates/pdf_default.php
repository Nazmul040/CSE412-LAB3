<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($resume['title']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        h2 {
            color: #2c3e50;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-top: 20px;
        }
        .contact-info {
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars($resume_data['personal']['fullname'] ?? 'Resume'); ?></h1>
    
    <div class="contact-info">
        <?php if (!empty($resume_data['personal']['email'])): ?>
            <div><?php echo htmlspecialchars($resume_data['personal']['email']); ?></div>
        <?php endif; ?>
        
        <?php if (!empty($resume_data['personal']['phone'])): ?>
            <div><?php echo htmlspecialchars($resume_data['personal']['phone']); ?></div>
        <?php endif; ?>
    </div>
    
    <?php if (!empty($resume_data['personal']['summary'])): ?>
        <div class="section">
            <h2>Professional Summary</h2>
            <p><?php echo nl2br(htmlspecialchars($resume_data['personal']['summary'])); ?></p>
        </div>
    <?php endif; ?>
    
    <?php if (isset($resume_data['education']) && !empty($resume_data['education'][0]['institution'])): ?>
        <div class="section">
            <h2>Education</h2>
            <?php foreach ($resume_data['education'] as $education): ?>
                <?php if (!empty($education['institution'])): ?>
                    <div>
                        <h3><?php echo htmlspecialchars($education['degree']); ?></h3>
                        <div>
                            <?php echo htmlspecialchars($education['institution']); ?>
                            <?php if (!empty($education['location'])): ?>
                                , <?php echo htmlspecialchars($education['location']); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <!-- Add more sections as needed -->
</body>
</html>