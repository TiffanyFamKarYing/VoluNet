<!-- partials/footer.php -->
<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="index.php" class="logo">
                    <div class="logo-mark"><i class="fas fa-handshake"></i></div>
                    <div class="logo-text" style="color:#fff">Volu<em>Net</em></div>
                </a>
                <p>Connecting passionate volunteers with non-profit organisations to create lasting impact across Malaysia.</p>
            </div>
            <div class="footer-col">
                <h4>Platform</h4>
                <ul>
                    <li><a href="index.php"><i class="fas fa-house"></i>Home</a></li>
                    <li><a href="aboutus.php"><i class="fas fa-circle-info"></i>About Us</a></li>
                    <li><a href="opportunity.php"><i class="fas fa-magnifying-glass"></i>Opportunities</a></li>
                    <li><a href="resources.php"><i class="fas fa-book-open"></i>Resources</a></li>
                    <li><a href="register.php"><i class="fas fa-user-plus"></i>Register</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Sectors</h4>
                <ul>
                    <li><a href="opportunity.php?sector=Technology"><i class="fas fa-laptop-code"></i>Technology</a></li>
                    <li><a href="opportunity.php?sector=Education"><i class="fas fa-graduation-cap"></i>Education</a></li>
                    <li><a href="opportunity.php?sector=Environment"><i class="fas fa-leaf"></i>Environment</a></li>
                    <li><a href="opportunity.php?sector=Community"><i class="fas fa-people-group"></i>Community</a></li>
                    <li><a href="opportunity.php?sector=Marketing"><i class="fas fa-bullhorn"></i>Marketing</a></li>
                    <li><a href="opportunity.php?sector=Animal+Welfare"><i class="fas fa-paw"></i>Animal Welfare</a></li>
                    <li><a href="opportunity.php?sector=Disaster+Relief"><i class="fas fa-hand-holding-heart"></i>Disaster Relief</a></li>
                    <li><a href="opportunity.php?sector=Arts"><i class="fas fa-palette"></i>Arts &amp; Culture</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="aboutus.php"><i class="fas fa-circle-info"></i>About Us</a></li>
                    <li><a href="#" onclick="openInfoModal('contactModal');return false;"><i class="fas fa-envelope"></i>Contact</a></li>
                    <li><a href="#" onclick="openInfoModal('privacyModal');return false;"><i class="fas fa-shield-halved"></i>Privacy Policy</a></li>
                    <li><a href="#" onclick="openInfoModal('termsModal');return false;"><i class="fas fa-file-contract"></i>Terms of Use</a></li>
                    <li><a href="#" onclick="openInfoModal('faqModal');return false;"><i class="fas fa-circle-question"></i>FAQ</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> VoluNet. All rights reserved.</p>
            <div class="social-links">
                <a href="https://www.facebook.com/volunet.my" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.x.com/volunet_my" target="_blank" rel="noopener noreferrer" aria-label="Twitter / X"><i class="fab fa-x-twitter"></i></a>
                <a href="https://www.linkedin.com/company/volunet-malaysia" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://www.instagram.com/volunet.my" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</footer>

<!-- INFO MODALS — Contact / Privacy Policy / Terms of Use -->
<!-- CONTACT MODAL -->
<div class="info-modal-overlay" id="contactModal" onclick="handleInfoModalClick(event,'contactModal')">
    <div class="info-modal-box">
        <div class="info-modal-head">
            <div class="info-modal-icon"><i class="fas fa-envelope"></i></div>
            <div>
                <h2>Contact Us</h2>
                <p>We'd love to hear from you</p>
            </div>
            <button class="info-modal-close" onclick="closeInfoModal('contactModal')" aria-label="Close">&times;</button>
        </div>
        <div class="info-modal-body">
            <div class="info-contact-grid">
                <div class="info-contact-card">
                    <div class="info-contact-icon" style="background:var(--blue-50);color:var(--blue-600)"><i class="fas fa-envelope"></i></div>
                    <div>
                        <strong>Email Us</strong>
                        <a href="mailto:hello@volunet.my">hello@volunet.my</a>
                    </div>
                </div>
                <div class="info-contact-card">
                    <div class="info-contact-icon" style="background:var(--green-50);color:var(--green-600)"><i class="fas fa-phone"></i></div>
                    <div>
                        <strong>Call Us</strong>
                        <a href="tel:+60312345678">+603 1234 5678</a>
                    </div>
                </div>
                <div class="info-contact-card">
                    <div class="info-contact-icon" style="background:var(--orange-50);color:var(--orange-500)"><i class="fas fa-location-dot"></i></div>
                    <div>
                        <strong>Our Office</strong>
                        <span style="display:block;color:#374151;font-size:12px;line-height:1.5">
                            No. 12, Persiaran Jalil 1,<br>
                            Bukit Jalil, 57000<br>
                            <a href="https://maps.google.com/?q=Persiaran+Jalil+1,+Bukit+Jalil,+57000+Kuala+Lumpur,+Malaysia"
                               target="_blank" rel="noopener noreferrer"
                               style="color:var(--orange-500);font-weight:700;font-size:11.5px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-top:4px;transition:color .2s"
                               onmouseover="this.style.color='var(--orange-600)'"
                               onmouseout="this.style.color='var(--orange-500)'">
                                <i class="fas fa-map-location-dot" style="font-size:11px"></i> View on Google Maps
                            </a>
                        </span>
                    </div>
                </div>
                <div class="info-contact-card">
                    <div class="info-contact-icon" style="background:#fdf2f8;color:#db2777"><i class="fas fa-clock"></i></div>
                    <div>
                        <strong>Office Hours</strong>
                        <span>Mon–Fri, 9am–6pm MYT</span>
                    </div>
                </div>
            </div>
            <div class="info-divider"></div>
            <h3 class="info-section-title"><i class="fas fa-paper-plane"></i> Send a Message</h3>
            <div class="info-form-row">
                <div class="form-group" style="margin-bottom:0">
                    <label>Your Name</label>
                    <input type="text" placeholder="e.g. Ahmad bin Ali">
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label>Email Address</label>
                    <input type="email" placeholder="you@example.com">
                </div>
            </div>
            <div class="form-group" style="margin-bottom:14px;margin-top:14px">
                <label>Subject</label>
                <input type="text" placeholder="How can we help?">
            </div>
            <div class="form-group" style="margin-bottom:18px">
                <label>Message</label>
                <textarea rows="4" placeholder="Tell us more..."></textarea>
            </div>
            <button class="btn btn-primary" style="width:100%;justify-content:center" onclick="handleContactSubmit(this)">
                <i class="fas fa-paper-plane"></i> Send Message
            </button>
        </div>
    </div>
</div>

<!-- PRIVACY POLICY MODAL -->
<div class="info-modal-overlay" id="privacyModal" onclick="handleInfoModalClick(event,'privacyModal')">
    <div class="info-modal-box">
        <div class="info-modal-head">
            <div class="info-modal-icon" style="background:rgba(255,255,255,.15);color:#7dd3fc"><i class="fas fa-shield-halved"></i></div>
            <div>
                <h2>Privacy Policy</h2>
                <p>Last updated: January 2025</p>
            </div>
            <button class="info-modal-close" onclick="closeInfoModal('privacyModal')" aria-label="Close">&times;</button>
        </div>
        <div class="info-modal-body info-modal-scroll">
            <p class="info-intro">VoluNet is committed to protecting your personal information. This policy explains how we collect, use, and safeguard your data.</p>

            <h3 class="info-section-title"><i class="fas fa-database"></i> Information We Collect</h3>
            <p>When you register or apply for opportunities, we collect: your full name, email address, phone number, location, and the cover letters you submit. We do not collect sensitive financial data.</p>

            <h3 class="info-section-title"><i class="fas fa-gears"></i> How We Use Your Data</h3>
            <ul class="info-list">
                <li>To match you with relevant volunteer opportunities</li>
                <li>To allow organisations to review your applications</li>
                <li>To send you updates about your applications and platform news</li>
                <li>To improve our platform features and user experience</li>
            </ul>

            <h3 class="info-section-title"><i class="fas fa-share-nodes"></i> Data Sharing</h3>
            <p>We share your application details only with the specific organisation you apply to. We never sell your data to third parties or use it for advertising purposes.</p>

            <h3 class="info-section-title"><i class="fas fa-lock"></i> Data Security</h3>
            <p>Your data is stored securely using industry-standard encryption. Passwords are hashed using bcrypt and are never stored in plain text. We use Supabase's secure infrastructure hosted within compliant data centres.</p>

            <h3 class="info-section-title"><i class="fas fa-user-check"></i> Your Rights</h3>
            <ul class="info-list">
                <li>Access and download your personal data at any time from your Profile page</li>
                <li>Request correction of inaccurate information</li>
                <li>Request deletion of your account and associated data</li>
                <li>Withdraw consent for communications at any time</li>
            </ul>

            <h3 class="info-section-title"><i class="fas fa-cookie-bite"></i> Cookies</h3>
            <p>We use session cookies strictly to keep you logged in. We do not use tracking or advertising cookies.</p>

            <div class="info-contact-note">
                <i class="fas fa-envelope"></i>
                Questions about your privacy? Email us at <a href="mailto:privacy@volunet.my">privacy@volunet.my</a>
            </div>
        </div>
    </div>
</div>

<!-- TERMS OF USE MODAL -->
<div class="info-modal-overlay" id="termsModal" onclick="handleInfoModalClick(event,'termsModal')">
    <div class="info-modal-box">
        <div class="info-modal-head">
            <div class="info-modal-icon" style="background:rgba(255,255,255,.15);color:#fdba74"><i class="fas fa-file-contract"></i></div>
            <div>
                <h2>Terms of Use</h2>
                <p>Last updated: January 2025</p>
            </div>
            <button class="info-modal-close" onclick="closeInfoModal('termsModal')" aria-label="Close">&times;</button>
        </div>
        <div class="info-modal-body info-modal-scroll">
            <p class="info-intro">By using VoluNet, you agree to these terms. Please read them carefully before registering or applying for opportunities.</p>

            <h3 class="info-section-title"><i class="fas fa-circle-check"></i> Eligibility</h3>
            <p>VoluNet is open to anyone aged 16 and above who wishes to volunteer or find paid positions with registered Malaysian non-profit organisations. By registering, you confirm that the information you provide is accurate and truthful.</p>

            <h3 class="info-section-title"><i class="fas fa-user-shield"></i> User Responsibilities</h3>
            <ul class="info-list">
                <li>Provide honest and accurate information in your profile and applications</li>
                <li>Respect the organisations and fellow volunteers on the platform</li>
                <li>Not create multiple accounts or impersonate others</li>
                <li>Not use the platform for spam, fraud, or any unlawful activity</li>
                <li>Honour commitments made to organisations upon acceptance</li>
            </ul>

            <h3 class="info-section-title"><i class="fas fa-building"></i> Organisation Responsibilities</h3>
            <ul class="info-list">
                <li>Post only legitimate, legal, and accurate volunteer opportunities</li>
                <li>Treat volunteers with dignity and respect</li>
                <li>Not use volunteer data for purposes unrelated to the posted opportunity</li>
                <li>Respond to applications within a reasonable timeframe</li>
            </ul>

            <h3 class="info-section-title"><i class="fas fa-triangle-exclamation"></i> Prohibited Conduct</h3>
            <p>The following are strictly prohibited: posting misleading opportunities, harvesting user data, attempting to hack or disrupt the platform, or using VoluNet to recruit for illegal activities. Violations may result in immediate account suspension.</p>

            <h3 class="info-section-title"><i class="fas fa-gavel"></i> Limitation of Liability</h3>
            <p>VoluNet serves as a platform connecting volunteers and organisations. We are not responsible for the conduct of users or organisations outside of the platform, nor for any disputes arising from volunteer engagements.</p>

            <h3 class="info-section-title"><i class="fas fa-rotate"></i> Changes to Terms</h3>
            <p>We may update these terms periodically. Continued use of VoluNet after changes are posted constitutes your acceptance of the new terms. We will notify registered users of significant changes via email.</p>

            <div class="info-contact-note">
                <i class="fas fa-envelope"></i>
                Questions about these terms? Email us at <a href="mailto:legal@volunet.my">legal@volunet.my</a>
            </div>
        </div>
    </div>
</div>

<!-- FAQ MODAL -->
<div class="info-modal-overlay" id="faqModal" onclick="handleInfoModalClick(event,'faqModal')">
    <div class="info-modal-box" style="max-width:680px">
        <div class="info-modal-head">
            <div class="info-modal-icon" style="background:rgba(255,255,255,.15);color:#86efac"><i class="fas fa-circle-question"></i></div>
            <div>
                <h2>Frequently Asked Questions</h2>
                <p>Everything you need to know about VoluNet</p>
            </div>
            <button class="info-modal-close" onclick="closeInfoModal('faqModal')" aria-label="Close">&times;</button>
        </div>
        <div class="info-modal-body info-modal-scroll" style="padding:0">

            <!-- Search bar -->
            <div style="padding:18px 24px 0">
                <div style="position:relative">
                    <i class="fas fa-magnifying-glass" style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:13px"></i>
                    <input type="text" id="faqSearch" oninput="filterFAQ(this.value)"
                           placeholder="Search questions…"
                           style="width:100%;padding:9px 14px 9px 36px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:13.5px;font-family:inherit;color:#111827;background:#f9fafb;outline:none;transition:border-color .2s"
                           onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff'"
                           onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'">
                </div>
            </div>

            <!-- Category tabs -->
            <div style="display:flex;gap:6px;flex-wrap:wrap;padding:14px 24px 0" id="faqTabs">
                <button class="faq-tab active" onclick="setFAQTab('all',this)">All</button>
                <button class="faq-tab" onclick="setFAQTab('general',this)">General</button>
                <button class="faq-tab" onclick="setFAQTab('volunteers',this)">Volunteers</button>
                <button class="faq-tab" onclick="setFAQTab('organisations',this)">Organisations</button>
                <button class="faq-tab" onclick="setFAQTab('account',this)">Account</button>
            </div>

            <!-- FAQ items -->
            <div id="faqList" style="padding:14px 24px 24px;display:flex;flex-direction:column;gap:8px">

                <!-- General -->
                <div class="faq-item" data-cat="general">
                    <button class="faq-q" onclick="toggleFAQ(this)">
                        <span>What is VoluNet?</span><i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-a">VoluNet is Malaysia's volunteer matching platform that connects passionate individuals with verified non-profit organisations. Whether you're looking for paid positions or unpaid volunteer work, VoluNet helps you find opportunities that match your skills and schedule.</div>
                </div>

                <div class="faq-item" data-cat="general">
                    <button class="faq-q" onclick="toggleFAQ(this)">
                        <span>Is VoluNet free to use?</span><i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-a">Yes, VoluNet is completely free for volunteers. Creating an account, browsing opportunities, and submitting applications costs nothing. We believe access to meaningful work should never come with a price tag.</div>
                </div>

                <div class="faq-item" data-cat="general">
                    <button class="faq-q" onclick="toggleFAQ(this)">
                        <span>What areas does VoluNet cover?</span><i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-a">VoluNet currently covers all states in Malaysia, including Kuala Lumpur, Selangor, Penang, Johor, Sabah, Sarawak, and more. We also list remote opportunities that are open to volunteers nationwide.</div>
                </div>

                <!-- Volunteers -->
                <div class="faq-item" data-cat="volunteers">
                    <button class="faq-q" onclick="toggleFAQ(this)">
                        <span>How do I apply for an opportunity?</span><i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-a">Simply create a free account, browse opportunities on the Opportunities page, and click <strong>"View Details"</strong> on any listing. From there you can submit a cover letter with your application. The organisation will review it and update your status.</div>
                </div>

                <div class="faq-item" data-cat="volunteers">
                    <button class="faq-q" onclick="toggleFAQ(this)">
                        <span>How long does it take to hear back after applying?</span><i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-a">Response times vary by organisation. Most aim to respond within 5–14 working days. You can track all your application statuses in real time from your <strong>My Applications</strong> page.</div>
                </div>

                <div class="faq-item" data-cat="volunteers">
                    <button class="faq-q" onclick="toggleFAQ(this)">
                        <span>Can I apply to multiple opportunities at once?</span><i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-a">Yes! You can apply to as many opportunities as you like simultaneously. We recommend tailoring your cover letter to each role to improve your chances of being selected.</div>
                </div>

                <div class="faq-item" data-cat="volunteers">
                    <button class="faq-q" onclick="toggleFAQ(this)">
                        <span>What are paid volunteer positions?</span><i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-a">Some organisations offer stipends or hourly rates for skilled roles — these are labelled <strong>"Paid"</strong> on the platform. They function like part-time or freelance positions within the non-profit sector. Unpaid roles are traditional volunteer positions where the reward is experience and impact.</div>
                </div>

                <div class="faq-item" data-cat="volunteers">
                    <button class="faq-q" onclick="toggleFAQ(this)">
                        <span>Will volunteering help my career?</span><i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-a">Absolutely. Volunteering builds real skills, expands your professional network, and demonstrates social responsibility to future employers. VoluNet also provides free courses and certifications through our <strong>Resources</strong> page to further boost your employability.</div>
                </div>

                <!-- Organisations -->
                <div class="faq-item" data-cat="organisations">
                    <button class="faq-q" onclick="toggleFAQ(this)">
                        <span>How can my organisation list opportunities on VoluNet?</span><i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-a">Contact our partnerships team at <a href="mailto:hello@volunet.my" style="color:#2563eb;font-weight:600">hello@volunet.my</a> to get your organisation verified and onboarded. Once approved, an admin account will be created for your team to post and manage listings directly.</div>
                </div>

                <div class="faq-item" data-cat="organisations">
                    <button class="faq-q" onclick="toggleFAQ(this)">
                        <span>Is there a cost for organisations to post listings?</span><i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-a">Verified non-profit organisations can post listings at no charge. We believe in removing barriers so that NGOs of all sizes — from small community groups to large foundations — can access skilled volunteers.</div>
                </div>

                <div class="faq-item" data-cat="organisations">
                    <button class="faq-q" onclick="toggleFAQ(this)">
                        <span>How does the verification process work?</span><i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-a">Our team reviews the organisation's registration documents (e.g. ROS certificate, company number) and verifies that listings are legitimate. This typically takes 3–5 business days, ensuring a safe and trustworthy experience for all volunteers.</div>
                </div>

                <!-- Account -->
                <div class="faq-item" data-cat="account">
                    <button class="faq-q" onclick="toggleFAQ(this)">
                        <span>How do I update my profile information?</span><i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-a">Log in and navigate to the <strong>Profile</strong> page from the top navigation. You can update your name, phone number, location, skills, and bio. A complete profile increases your chances of being selected by organisations.</div>
                </div>

                <div class="faq-item" data-cat="account">
                    <button class="faq-q" onclick="toggleFAQ(this)">
                        <span>Can I change my email address?</span><i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-a">Email addresses cannot be changed directly to protect account security. If you need to update your email, please contact us at <a href="mailto:hello@volunet.my" style="color:#2563eb;font-weight:600">hello@volunet.my</a> and we will assist you.</div>
                </div>

                <div class="faq-item" data-cat="account">
                    <button class="faq-q" onclick="toggleFAQ(this)">
                        <span>How do I delete my account?</span><i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-a">To request account deletion, email <a href="mailto:hello@volunet.my" style="color:#2563eb;font-weight:600">hello@volunet.my</a> from your registered address. We will remove all your personal data within 7 business days in accordance with our Privacy Policy.</div>
                </div>

            </div>

            <!-- No results -->
            <div id="faqNoResults" style="display:none;text-align:center;padding:32px 24px;color:#9ca3af">
                <i class="fas fa-magnifying-glass" style="font-size:28px;margin-bottom:10px;display:block"></i>
                No questions matched your search. Try a different keyword or
                <a href="mailto:hello@volunet.my" style="color:#2563eb;font-weight:600">contact us directly</a>.
            </div>

            <!-- Still have questions CTA -->
            <div style="margin:0 24px 24px;background:linear-gradient(135deg,#eff6ff,#f0fdf4);border:1px solid #dbeafe;border-radius:12px;padding:16px 18px;display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap">
                <div>
                    <div style="font-size:13px;font-weight:700;color:#1e40af;margin-bottom:3px"><i class="fas fa-headset" style="margin-right:6px"></i>Still have questions?</div>
                    <div style="font-size:12px;color:#6b7280">Our team usually replies within one business day.</div>
                </div>
                <a href="mailto:hello@volunet.my" class="btn btn-primary btn-sm"><i class="fas fa-envelope"></i> Email Us</a>
            </div>
        </div>
    </div>
</div>

<!-- Info Modal Styles -->
<style>
.info-modal-overlay{
    display:none;position:fixed;inset:0;z-index:600;
    background:rgba(7,15,35,.65);backdrop-filter:blur(8px);
    align-items:center;justify-content:center;padding:20px;
}
.info-modal-overlay.open{display:flex}

.info-modal-box{
    background:#fff;border-radius:20px;width:100%;max-width:600px;
    max-height:88vh;display:flex;flex-direction:column;
    box-shadow:0 32px 80px rgba(0,0,0,.28);overflow:hidden;
    animation:infoModalIn .28s cubic-bezier(0.34,1.56,0.64,1);
}
@keyframes infoModalIn{from{opacity:0;transform:scale(.93) translateY(18px)}to{opacity:1;transform:none}}

.info-modal-head{
    background:linear-gradient(135deg,#01091b 20%,#0b3288 60%,#1e6eb5 100%);
    padding:20px 24px;display:flex;align-items:center;gap:14px;
    position:relative;flex-shrink:0;
}
.info-modal-icon{
    width:44px;height:44px;border-radius:11px;flex-shrink:0;
    background:rgba(255,255,255,.15);
    display:flex;align-items:center;justify-content:center;font-size:19px;color:#fff;
}
.info-modal-head h2{font-family:'Lora',Georgia,serif;font-size:18px;font-weight:700;color:#fff;margin:0 0 2px}
.info-modal-head p{font-size:11.5px;color:rgba(255,255,255,.5);margin:0}
.info-modal-close{
    position:absolute;top:12px;right:14px;
    width:32px;height:32px;border-radius:8px;
    background:rgba(255,255,255,.14);color:#fff;border:none;
    cursor:pointer;font-size:20px;line-height:1;
    display:flex;align-items:center;justify-content:center;
    transition:background .2s;
}
.info-modal-close:hover{background:rgba(255,255,255,.28)}

.info-modal-body{padding:24px 26px;overflow-y:auto;flex:1;-webkit-overflow-scrolling:touch}

.info-intro{
    font-size:13.5px;line-height:1.75;color:#374151;
    background:#f8faff;border:1px solid #dbeafe;border-radius:10px;
    padding:13px 15px;margin-bottom:20px;
}

.info-section-title{
    display:flex;align-items:center;gap:8px;
    font-size:11.5px;font-weight:700;color:#2563eb;
    text-transform:uppercase;letter-spacing:.08em;
    margin:20px 0 8px;
}
.info-section-title i{font-size:12px}

.info-modal-body p{font-size:13.5px;line-height:1.8;color:#4b5563;margin-bottom:10px}
.info-list{padding-left:0;list-style:none;margin-bottom:10px;display:flex;flex-direction:column;gap:6px}
.info-list li{font-size:13.5px;color:#4b5563;line-height:1.65;padding-left:20px;position:relative}
.info-list li::before{content:'→';position:absolute;left:0;color:#2563eb;font-weight:700;font-size:12px;top:1px}

.info-divider{height:1px;background:#e5e7eb;margin:20px 0}

.info-contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.info-contact-card{
    display:flex;align-items:center;gap:11px;
    background:#f8faff;border:1px solid #dbeafe;
    border-radius:10px;padding:11px 13px;
}
.info-contact-icon{
    width:34px;height:34px;border-radius:8px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;font-size:14px;
}
.info-contact-card strong{display:block;font-size:11.5px;font-weight:700;color:#1f2937;margin-bottom:2px}
.info-contact-card a,.info-contact-card span{font-size:12px;color:#2563eb;text-decoration:none}
.info-contact-card span{color:#6b7280}
.info-contact-card a:hover{text-decoration:underline}

.info-form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}

.info-contact-note{
    background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;
    padding:11px 15px;font-size:13px;color:#15803d;
    display:flex;align-items:center;gap:9px;margin-top:20px;
}
.info-contact-note a{color:#15803d;font-weight:700}
.info-contact-note i{flex-shrink:0}

@media(max-width:540px){
    .info-modal-box{max-height:94vh;border-radius:14px}
    .info-modal-body{padding:16px 16px}
    .info-modal-head{padding:14px 16px}
    .info-contact-grid{grid-template-columns:1fr}
    .info-form-row{grid-template-columns:1fr}
}

.faq-tab{padding:5px 14px;border-radius:99px;font-size:12px;font-weight:700;border:1.5px solid #e5e7eb;background:#f9fafb;color:#6b7280;cursor:pointer;font-family:inherit;transition:all .18s}
.faq-tab:hover{border-color:#93c5fd;color:#2563eb;background:#eff6ff}
.faq-tab.active{background:#2563eb;color:#fff;border-color:#2563eb}
.faq-item{border:1.5px solid #e5e7eb;border-radius:12px;overflow:hidden;transition:border-color .2s}
.faq-item:hover{border-color:#93c5fd}
.faq-item.faq-open{border-color:#3b82f6}
.faq-q{width:100%;display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 16px;background:none;border:none;cursor:pointer;font-family:inherit;font-size:13.5px;font-weight:700;color:#111827;text-align:left;transition:background .15s}
.faq-q:hover{background:#f8faff}
.faq-item.faq-open .faq-q{background:#eff6ff;color:#1d4ed8}
.faq-q i{font-size:11px;color:#9ca3af;flex-shrink:0;transition:transform .28s cubic-bezier(.4,0,.2,1)}
.faq-item.faq-open .faq-q i{transform:rotate(180deg);color:#3b82f6}
.faq-a{max-height:0;overflow:hidden;font-size:13.5px;color:#4b5563;line-height:1.75;transition:max-height .32s cubic-bezier(.4,0,.2,1),padding .28s ease;padding:0 16px}
.faq-item.faq-open .faq-a{max-height:300px;padding:0 16px 14px}
.faq-item.faq-hidden{display:none}
@media(max-width:540px){.faq-tab{font-size:11px;padding:4px 11px}}
</style>

<div id="pageLoader"><div class="loader-ring"></div><p>Please wait…</p></div>

<button id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Back to top"><i class="fas fa-arrow-up"></i></button>

<script>
const hdr = document.getElementById('siteHeader');
window.addEventListener('scroll', () => {
    hdr.classList.toggle('scrolled', window.scrollY > 20);
    document.getElementById('backToTop').classList.toggle('visible', window.scrollY > 400);
}, { passive: true });

function toggleMobileNav() {
    const nav = document.getElementById('mobileNav');
    const ham = document.getElementById('hamburger');
    nav.classList.toggle('open');
    ham.classList.toggle('open');
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#mobileNav a').forEach(function(a) {
        a.addEventListener('click', function() {
            document.getElementById('mobileNav').classList.remove('open');
            document.getElementById('hamburger').classList.remove('open');
        });
    });
  
    document.addEventListener('click', function(e) {
        const nav = document.getElementById('mobileNav');
        const ham = document.getElementById('hamburger');
        const hdr = document.getElementById('siteHeader');
        if (nav.classList.contains('open') && !hdr.contains(e.target)) {
            nav.classList.remove('open');
            ham.classList.remove('open');
        }
    });
});

function openModal(id)  { document.getElementById(id).classList.add('open');    document.body.style.overflow = 'hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow = ''; }
['applyModal','deleteModal'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('click', e => { if (e.target === el) closeModal(id); });
});

function openInfoModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeInfoModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}
function handleInfoModalClick(e, id) {
    if (e.target === document.getElementById(id)) closeInfoModal(id);
}

function handleContactSubmit(btn) {
    btn.innerHTML = '<i class="fas fa-circle-check"></i> Message Sent!';
    btn.style.background = 'var(--green-600)';
    btn.disabled = true;
    setTimeout(() => {
        closeInfoModal('contactModal');
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Message';
            btn.style.background = '';
            btn.disabled = false;
        }, 400);
    }, 1800);
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeModal('applyModal');
        closeModal('deleteModal');
        ['contactModal','privacyModal','termsModal','faqModal'].forEach(closeInfoModal);
    }
});

function toggleFAQ(btn) {
    const item = btn.closest('.faq-item');
    const isOpen = item.classList.contains('faq-open');
    document.querySelectorAll('.faq-item.faq-open').forEach(i => i.classList.remove('faq-open'));
    if (!isOpen) item.classList.add('faq-open');
}
let activeFAQTab = 'all';
function setFAQTab(cat, btn) {
    activeFAQTab = cat;
    document.querySelectorAll('.faq-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.faq-item.faq-open').forEach(i => i.classList.remove('faq-open'));
    applyFAQFilters();
}
function filterFAQ(val) { applyFAQFilters(val.toLowerCase().trim()); }
function applyFAQFilters(search) {
    if (search === undefined) search = (document.getElementById('faqSearch')?.value || '').toLowerCase().trim();
    let visible = 0;
    document.querySelectorAll('.faq-item').forEach(item => {
        const catMatch = activeFAQTab === 'all' || item.dataset.cat === activeFAQTab;
        const searchMatch = !search || item.textContent.toLowerCase().includes(search);
        if (catMatch && searchMatch) { item.classList.remove('faq-hidden'); visible++; }
        else { item.classList.add('faq-hidden'); item.classList.remove('faq-open'); }
    });
    const nr = document.getElementById('faqNoResults');
    if (nr) nr.style.display = visible === 0 ? 'block' : 'none';
}

const _origClose = closeInfoModal;
closeInfoModal = function(id) {
    _origClose(id);
    if (id === 'faqModal') {
        const s = document.getElementById('faqSearch'); if (s) s.value = '';
        activeFAQTab = 'all';
        document.querySelectorAll('.faq-tab').forEach((t,i) => t.classList.toggle('active', i === 0));
        document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('faq-hidden','faq-open'));
        const nr = document.getElementById('faqNoResults'); if (nr) nr.style.display = 'none';
    }
};


function confirmDelete(id, name) {
    document.getElementById('deleteOppId').value = id;
    document.getElementById('deleteOppName').textContent = name;
    openModal('deleteModal');
}

function switchTab(name) {
    document.querySelectorAll('.admin-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.admin-panel').forEach(p => p.classList.remove('active'));
    const btn = [...document.querySelectorAll('.admin-tab')].find(t => t.getAttribute('onclick')?.includes(name));
    if (btn) btn.classList.add('active');
    const panel = document.getElementById('panel-' + name);
    if (panel) panel.classList.add('active');
}

function toggleRateFields(suffix) {
    const cb = document.getElementById('is_paid_' + suffix);
    const el = document.getElementById('rateFields-' + suffix);
    if (!el || !cb) return;
    el.style.display = cb.checked ? 'block' : 'none';
}

document.querySelectorAll('.js-form').forEach(f => {
    f.addEventListener('submit', function(e) {
        const p1 = document.getElementById('pw1'), p2 = document.getElementById('pw2');
        if (p1 && p2 && p1.value !== p2.value) {
            e.preventDefault();
            alert('Passwords do not match.');
            return;
        }
        if (this.id !== 'deleteForm') {
            document.getElementById('pageLoader').classList.add('visible');
        }
    });
});

const ro = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('revealed'); ro.unobserve(e.target); } });
}, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
document.querySelectorAll('[data-reveal]').forEach(el => ro.observe(el));

function countUp(el, target) {
    const dur = 1800; const start = performance.now();
    const fmt = n => { if (n < 1000) return n.toLocaleString()+'+'; const k = n/1000; return (Number.isInteger(k) ? k : parseFloat(k.toFixed(1)))+'K+'; };
    const step = now => {
        const p = Math.min((now-start)/dur, 1);
        const ease = 1 - Math.pow(1-p, 3);
        el.textContent = fmt(Math.floor(ease*target));
        if (p < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
}
const co = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { countUp(e.target, +e.target.dataset.count); co.unobserve(e.target); } });
}, { threshold: 0.5 });
document.querySelectorAll('[data-count]').forEach(el => co.observe(el));

const cardObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            const siblings = Array.from(e.target.parentElement?.children || []);
            const delay = siblings.indexOf(e.target) * 60;
            setTimeout(() => { e.target.style.opacity = '1'; e.target.style.transform = 'none'; }, delay);
            cardObs.unobserve(e.target);
        }
    });
}, { threshold: 0.06 });
document.querySelectorAll('.opp-card,.feature-card,.res-card,.testi-card,.value-card,.team-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(16px)';
    el.style.transition = 'opacity .45s ease,transform .45s ease,border-color .3s ease,box-shadow .3s ease';
    cardObs.observe(el);
});
</script>
</body>
</html>