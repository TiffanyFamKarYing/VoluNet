<?php
$e = $editOpportunity ?? null;

$suffix = $e ? 'edit' : 'add';

// Pre-fill values
$v_title           = htmlspecialchars($e['title']           ?? '');
$v_sector          = htmlspecialchars($e['sector']          ?? '');
$v_location        = htmlspecialchars($e['location']        ?? '');
$v_description     = htmlspecialchars($e['description']     ?? '');
$v_time_commitment = htmlspecialchars($e['time_commitment'] ?? '');
$v_is_paid         = !empty($e['is_paid']);
$v_rate            = $e['rate']      ?? '';
$v_rate_type       = $e['rate_type'] ?? 'hourly';

// Skills array -> comma string
$skillsArr = [];
if (!empty($e['required_skills'])) {
    $s = $e['required_skills'];
    if (is_string($s)) $s = json_decode($s, true) ?? [$s];
    $skillsArr = (array)$s;
}
$v_skills = htmlspecialchars(implode(', ', $skillsArr));
?>
<div class="form-group">
    <label><i class="fas fa-heading" style="color:var(--blue-400)"></i> Title <span class="req">*</span></label>
    <input type="text" name="title" value="<?= $v_title ?>"
           placeholder="e.g. Community Outreach Coordinator" required>
</div>
<div class="form-row">
    <div class="form-group">
        <label><i class="fas fa-tag" style="color:var(--blue-400)"></i> Sector <span class="req">*</span></label>
        <input type="text" name="sector" value="<?= $v_sector ?>"
               placeholder="e.g. Technology, Education" required>
    </div>
    <div class="form-group">
        <label><i class="fas fa-location-dot" style="color:var(--blue-400)"></i> Location <span class="req">*</span></label>
        <input type="text" name="location" value="<?= $v_location ?>"
               placeholder="e.g. Kuala Lumpur" required>
    </div>
</div>
<div class="form-group">
    <label><i class="fas fa-align-left" style="color:var(--blue-400)"></i> Description <span class="req">*</span></label>
    <textarea name="description" rows="4"
              placeholder="Describe the role, responsibilities, and what volunteers will gain..." required><?= $v_description ?></textarea>
</div>
<div class="form-row">
    <div class="form-group">
        <label><i class="fas fa-screwdriver-wrench" style="color:var(--blue-400)"></i> Required Skills</label>
        <input type="text" name="required_skills" value="<?= $v_skills ?>"
               placeholder="e.g. Communication, Teamwork">
        <div class="form-hint">Comma-separated.</div>
    </div>
    <div class="form-group">
        <label><i class="fas fa-clock" style="color:var(--blue-400)"></i> Time Commitment <span class="req">*</span></label>
        <input type="text" name="time_commitment" value="<?= $v_time_commitment ?>"
               placeholder="e.g. 10 hrs/week" required>
    </div>
</div>
<div class="checkbox-row">
    <input type="checkbox" id="is_paid_<?= $suffix ?>" name="is_paid"
           onchange="toggleRateFields('<?= $suffix ?>')"
           <?= $v_is_paid ? 'checked' : '' ?>>
    <label for="is_paid_<?= $suffix ?>">
        <i class="fas fa-circle-dollar-to-slot" style="color:var(--green-600)"></i> This is a paid position
    </label>
</div>
<div id="rateFields-<?= $suffix ?>" style="display:<?= $v_is_paid ? 'block' : 'none' ?>">
    <div class="form-row">
        <div class="form-group">
            <label><i class="fas fa-money-bill" style="color:var(--green-600)"></i> Rate (RM)</label>
            <input type="number" name="rate" step="0.01" min="0" value="<?= $v_rate ?>" placeholder="e.g. 25.00">
        </div>
        <div class="form-group">
            <label><i class="fas fa-calendar-days" style="color:var(--blue-400)"></i> Rate Type</label>
            <select name="rate_type">
                <option value="hourly"   <?= $v_rate_type === 'hourly'   ? 'selected' : '' ?>>Per Hour</option>
                <option value="per_task" <?= $v_rate_type === 'per_task' ? 'selected' : '' ?>>Per Task</option>
            </select>
        </div>
    </div>
</div>
