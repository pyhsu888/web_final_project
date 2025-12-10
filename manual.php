<?php
session_start(); date_default_timezone_set('Asia/Taipei');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'db_connect.php';
require 'lang.php'; 

include 'header.php';
?>

<div class="container">
    <h2 class="section-title">💡 <?php echo __('manual_title'); ?></h2>
    
    <div class="manual-section">
        <h3><?php echo __('manual_section_1_title'); ?></h3>
        <p><?php echo __('manual_section_1_content_1'); ?></p>
        <ul>
            <li><?php echo __('manual_section_1_list_1'); ?></li>
            <li><?php echo __('manual_section_1_list_2'); ?></li>
            <li><?php echo __('manual_section_1_list_3'); ?></li>
        </ul>
    </div>

    <div class="manual-section">
        <h3><?php echo __('manual_section_2_title'); ?></h3>
        <p><?php echo __('manual_section_2_content_1'); ?></p>
        <ol>
            <li><?php echo __('manual_section_2_step_1'); ?></li>
            <li><?php echo __('manual_section_2_step_2'); ?></li>
            <li><?php echo __('manual_section_2_step_3'); ?></li>
        </ol>
    </div>

    <hr style="border: 0; border-top: 1px solid #ddd; margin: 40px 0;">

    <h2 class="section-title">📸 <?php echo __('manual_step_title'); ?></h2>

    <div class="manual-grid">
        
        <div class="step-card">
            <div class="step-text">
                <h3><?php echo __('step_1_title'); ?></h3>
                <p><?php echo __('step_1_desc'); ?></p>
            </div>
            <img src="images/1.png" alt="Login Screen">
        </div>

        <div class="step-card">
            <div class="step-text">
                <h3><?php echo __('step_2_title'); ?></h3>
                <p><?php echo __('step_2_desc'); ?></p>
            </div>
            <img src="images/2.png" alt="Select Room">
        </div>

        <div class="step-card">
            <div class="step-text">
                <h3><?php echo __('step_3_title'); ?></h3>
                <p><?php echo __('step_3_desc'); ?></p>
            </div>
            <img src="images/3.png" alt="Reservation Table">
        </div>

        <div class="step-card">
            <div class="step-text">
                <h3><?php echo __('step_4_title'); ?></h3>
                <p><?php echo __('step_4_desc'); ?></p>
            </div>
            <img src="images/4.png" alt="My Reservations">
        </div>

        <div class="step-card">
            <div class="step-text">
                <h3><?php echo __('step_5_title'); ?></h3>
                <p><?php echo __('step_5_desc'); ?></p>
            </div>
            <img src="images/5.png" alt="Food">
        </div>

    </div>
    
    <style>
        .manual-section {
            margin-bottom: 30px;
            padding: 15px;
            border-left: 5px solid #007bff;
            background-color: var(--bg-secondary, #f8f8f8);
            border-radius: 4px;
        }
        .manual-section h3 {
            color: #007bff;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .manual-section ul, .manual-section ol {
            margin-left: 20px;
        }

        .manual-grid {
            display: flex;
            flex-direction: column;
            gap: 30px;
            margin-bottom: 40px;
        }

        .step-card {
            background-color: var(--bg-secondary, #fff);
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 20px;
        }

        .step-text {
            flex: 1; 
        }
        .step-text h3 {
            color: #007bff;
            margin-top: 0;
        }
        .step-text p {
            line-height: 1.6;
            color: #555;
            margin-bottom: 0;
        }
        img {
            max-width: 50%;
            height: auto;
            border-radius: 4px;
            display: block;
            margin: 0 auto;
        }


        @media (max-width: 768px) {
            .step-card {
                flex-direction: column;
                align-items: flex-start;
            }
            img {
                max-width: 100%;
            }
        }
        
        html[data-theme="dark"] .manual-section {
             background-color: var(--bg-tertiary, #2a2a2a);
             border-left-color: #00aaff;
             color: #ddd;
        }
        html[data-theme="dark"] .step-card {
            background-color: #2a2a2a;
            border-color: #444;
        }
        html[data-theme="dark"] .step-text h3 {
            color: #4dabf7;
        }
        html[data-theme="dark"] .step-text p {
            color: #ccc;
        }
        html[data-theme="dark"] .step-image {
            background-color: #333;
            border-color: #555;
        }
    </style>

</div>

<?php include 'footer.php'; ?>