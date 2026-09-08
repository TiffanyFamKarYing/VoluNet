-- I use Supabase for this project, which is built on PostgreSQL. This SQL file creates the necessary tables and seeds them with initial data for testing and development purposes. The tables include users, opportunities, applications, and resources, along with appropriate policies for row-level security.
-- Sir can check email and accept the invitation link I sent before accessing the Supabase dashboard and database that I made for this project. Thank you!
-- Supabase Link: https://supabase.com/dashboard/project/bmdswvdqnlpkaqqptqdf

-- 1. USERS TABLE
CREATE TABLE IF NOT EXISTS users (
  id         uuid DEFAULT gen_random_uuid() PRIMARY KEY,
  email      text UNIQUE NOT NULL,
  password   text NOT NULL,
  full_name  text NOT NULL,
  phone      text,
  location   text,
  bio        text,
  skills     jsonb DEFAULT '[]',
  is_admin   boolean DEFAULT false,
  created_at timestamptz DEFAULT now()
);

-- 2. OPPORTUNITIES TABLE
CREATE TABLE IF NOT EXISTS opportunities (
  id               uuid DEFAULT gen_random_uuid() PRIMARY KEY,
  title            text NOT NULL,
  sector           text NOT NULL,
  description      text NOT NULL,
  location         text NOT NULL,
  is_paid          boolean DEFAULT false,
  rate             numeric(10,2) DEFAULT 0,
  rate_type        text DEFAULT 'hourly',
  time_commitment  text,
  required_skills  jsonb DEFAULT '[]',
  status           text DEFAULT 'active',
  created_by       uuid,
  created_at       timestamptz DEFAULT now()
);

--  OPPORTUNITIES  (12)
INSERT INTO opportunities
  (title, sector, description, location, is_paid, rate, rate_type, time_commitment, required_skills, status)
VALUES

(
  'Web Developer for NGO Website',
  'Technology',
  'Design and develop a responsive website for a Kuala Lumpur-based non-profit that supports underprivileged youth. You will collaborate with the communications team to create an engaging, accessible site using modern web technologies.',
  'Ampang, Kuala Lumpur',
  true, 30.00, 'hourly',
  '12 hrs/week',
  '["HTML", "CSS", "JavaScript", "WordPress"]',
  'active'
),

(
  'English Tutor for Underprivileged Kids',
  'Education',
  'Provide weekly English tutoring sessions to primary-school children from low-income families in Petaling Jaya. Help students improve reading comprehension, conversational English, and written expression through fun, interactive lessons.',
  'Sunway, Selangor',
  false, 0, 'hourly',
  '6 hrs/week',
  '["Teaching", "English Proficiency", "Patience", "Lesson Planning"]',
  'active'
),

(
  'Social Media Content Creator',
  'Marketing',
  'Create compelling social media content — graphics, short videos, and copy — for a Malaysian environmental NGO. You will manage the organisation''s Instagram and Facebook presence, drive engagement, and amplify campaign reach.',
  'George Town, Penang',
  true, 20.00, 'hourly',
  '8 hrs/week',
  '["Canva", "Copywriting", "Instagram", "Video Editing"]',
  'active'
),

(
  'Community Garden Coordinator',
  'Environment',
  'Oversee a growing urban community garden initiative in Shah Alam. Responsibilities include planning planting schedules, coordinating volunteers, running composting workshops, and liaising with local councils to expand the project.',
  'Kota Kinabalu, Sabah',
  false, 0, 'hourly',
  '10 hrs/week',
  '["Horticulture", "Project Management", "Community Engagement"]',
  'active'
),

(
  'Animal Shelter Care Assistant',
  'Animal Welfare',
  'Assist at a local animal rescue shelter by feeding, grooming, and socialising rescued cats and dogs. Help with adoption drives, document animal health records, and support foster-home coordination for animals awaiting permanent homes.',
  'Kuching, Sarawak',
  false, 0, 'hourly',
  '8 hrs/week',
  '["Animal Handling", "Compassion", "Record Keeping", "Social Media"]',
  'active'
),

(
  'Flood Relief Logistics Coordinator',
  'Disaster Relief',
  'Support the coordination of flood relief operations across Pahang during the monsoon season. Duties include managing supply inventories, organising volunteer rosters, liaising with NADMA, and ensuring efficient last-mile distribution of aid.',
  'Kuantan, Pahang',
  true, 25.00, 'hourly',
  '20 hrs/week',
  '["Logistics", "Crisis Management", "Communication", "Microsoft Excel"]',
  'active'
),

(
  'Youth Leadership Programme Facilitator',
  'Youth Development',
  'Design and deliver leadership workshops for secondary school students aged 13–17 in Ipoh. Cover topics such as public speaking, teamwork, ethical decision-making, and career exploration to empower the next generation of leaders.',
  'Johor Bahru',
  true, 22.00, 'hourly',
  '10 hrs/week',
  '["Facilitation", "Public Speaking", "Curriculum Design", "Youth Work"]',
  'active'
),

(
  'Community Mural Artist',
  'Arts & Culture',
  'Collaborate with local residents and community groups in George Town to design and paint a large-scale mural celebrating Penang''s multicultural heritage. You will lead creative workshops to gather community input before finalising the design.',
  'Batu Ferringhi, Penang',
  false, 0, 'hourly',
  '15 hrs/week',
  '["Mural Painting", "Community Engagement", "Adobe Illustrator", "Colour Theory"]',
  'active'
),

(
  'Legal Literacy Workshop Trainer',
  'Legal Aid',
  'Conduct free legal literacy sessions for migrant workers and refugees in Klang Valley, covering topics such as workers'' rights, tenancy laws, and accessing legal aid. Materials will be provided; Bahasa Malaysia or English language ability is a bonus.',
  'Damansara, Selangor',
  true, 20.00, 'hourly',
  '6 hrs/week',
  '["Law Degree / Legal Background", "Training & Facilitation", "Empathy"]',
  'active'
),

(
  'Food Bank Sorting & Distribution Volunteer',
  'Food Security',
  'Join a leading Malaysian food bank to sort donated food items, pack meal parcels, and assist with distribution drives to urban poor communities in Johor Bahru. Weekend and weekday slots are both available.',
  'Bukit Jalil, Kuala Lumpur',
  false, 0, 'hourly',
  '5 hrs/week',
  '["Physical Fitness", "Teamwork", "Attention to Detail"]',
  'active'
),

(
  'Adaptive Sports Coach',
  'Sports & Recreation',
  'Coach wheelchair basketball and bocce sessions for youth and adults with physical disabilities at a Kuala Lumpur recreation centre. Design inclusive training drills, track participant progress, and organise friendly inter-centre tournaments.',
  'Puchong, Selangor',
  true, 18.00, 'hourly',
  '8 hrs/week',
  '["Sports Coaching", "Adaptive Sports Knowledge", "Inclusivity", "First Aid"]',
  'active'
),

(
  'Refugee Family Support Worker',
  'Social Work',
  'Provide practical and emotional support to refugee families in Ampang, assisting with school enrolment, access to community services, language integration, and navigating daily challenges in a new country.',
  'Cheras, Kuala Lumpur',
  false, 0, 'hourly',
  '12 hrs/week',
  '["Social Work", "Multilingual (English/BM/Chinese a bonus)", "Case Management", "Empathy"]',
  'active'
);

-- 3. APPLICATIONS TABLE
CREATE TABLE IF NOT EXISTS applications (
  id              uuid DEFAULT gen_random_uuid() PRIMARY KEY,
  opportunity_id  uuid NOT NULL,
  user_id         uuid NOT NULL,
  cover_letter    text,
  status          text DEFAULT 'pending',
  created_at      timestamptz DEFAULT now()
);

-- 4. RESOURCES TABLE
CREATE TABLE IF NOT EXISTS resources (
  id            uuid DEFAULT gen_random_uuid() PRIMARY KEY,
  title         text NOT NULL,
  description   text NOT NULL,
  url           text NOT NULL,
  resource_type text DEFAULT 'course',
  created_at    timestamptz DEFAULT now()
);

--  RESOURCES  (6 Courses, 3 Tutorials, 3 Certificates)
INSERT INTO resources
  (title, description, url, resource_type)
VALUES

-- COURSES (6)
(
  'Google Digital Garage: Fundamentals of Digital Marketing',
  'A free, IAB-accredited course covering SEO, social media, email marketing, and analytics. Perfect for volunteers looking to upskill in digital communications for their NGO work.',
  'https://learndigital.withgoogle.com/digitalgarage/course/digital-marketing',
  'course'
),

(
  'Coursera: Learning How to Learn',
  'A globally renowned free course from McMaster University on effective learning techniques, memory strategies, and overcoming procrastination — invaluable for tutors and educators.',
  'https://www.coursera.org/learn/learning-how-to-learn',
  'course'
),

(
  'UNHCR: Emergency Response & Disaster Preparedness Training',
  'An online training series by UNHCR covering disaster risk reduction, emergency logistics, community resilience frameworks, and coordinating relief operations effectively.',
  'https://emergency.unhcr.org/emergency-preparedness-and-response',
  'course'
),

(
  'FAO E-Learning: Introduction to Food Security & Nutrition',
  'A free self-paced course by the Food and Agriculture Organization covering food systems, urban agriculture, food waste reduction, and sustainable nutrition basics.',
  'https://elearning.fao.org/',
  'course'
),

(
  'YouthWork Academy: Facilitating Youth Workshops',
  'A free mini-course on designing and running engaging workshops for teenagers, covering icebreakers, discussion facilitation, conflict resolution, and session evaluation.',
  'https://www.elevify.com/en-ng/courses/education-humanities-and-social-sciences/education',
  'course'
),

(
  'Coursera: Introduction to Psychology & Community Support',
  'A free course from Yale University exploring human behaviour, empathy, and communication techniques — highly useful for volunteers in social work and refugee support roles.',
  'https://www.coursera.org/learn/the-science-of-well-being',
  'course'
),

-- TUTORIALS (3)
(
  'WWF Malaysia: Sustainability & Conservation Toolkit',
  'A practical guide and resource hub by WWF-Malaysia covering biodiversity, sustainable living, and community conservation strategies tailored for Malaysian ecosystems.',
  'https://www.wwf.org.my/get_involved/resources/',
  'tutorial'
),

(
  'Canva Design School: Visual Communication for Non-Profits',
  'Free video tutorials from Canva covering graphic design fundamentals, brand consistency, social media visuals, and creating impactful materials for community campaigns.',
  'https://www.canva.com/learn/design-school/',
  'tutorial'
),

(
  'UNDP: Community-Based Development Handbook',
  'An evidence-based handbook by UNDP outlining participatory community development approaches, needs assessment frameworks, and inclusive programme design methods.',
  'https://www.undp.org/publications',
  'tutorial'
),

-- CERTIFICATES (3)
(
  'edX: Non-Profit Management Certificate',
  'An online certificate programme covering non-profit governance, fundraising strategy, stakeholder engagement, and impact measurement — ideal for aspiring NGO leaders.',
  'https://www.edx.org/learn/nonprofit-management',
  'certificate'
),

(
  'Meta Blueprint: Social Media Marketing Fundamentals',
  'Free official certification courses from Meta covering Facebook, Instagram, and Reels marketing strategies, ad targeting, and content creation best practices.',
  'https://www.facebook.com/business/learn',
  'certificate'
),

(
  'PMI: Project Management Basics for Volunteers',
  'Free introductory resources from the Project Management Institute helping volunteers plan, execute, and evaluate community projects using agile and traditional PM methodologies.',
  'https://www.pmi.org/learning/library',
  'certificate'
);

-- These are the Policies
-- USERS
ALTER TABLE users ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Allow public select" ON users FOR SELECT USING (true);
CREATE POLICY "Allow public insert" ON users FOR INSERT WITH CHECK (true);
CREATE POLICY "Allow public update" ON users FOR UPDATE USING (true);
CREATE POLICY "Allow public delete" ON users FOR DELETE USING (true);

-- OPPORTUNITIES
ALTER TABLE opportunities ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Allow public select" ON opportunities FOR SELECT USING (true);
CREATE POLICY "Allow public insert" ON opportunities FOR INSERT WITH CHECK (true);
CREATE POLICY "Allow public update" ON opportunities FOR UPDATE USING (true);
CREATE POLICY "Allow public delete" ON opportunities FOR DELETE USING (true);

-- APPLICATIONS
ALTER TABLE applications ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Allow public select" ON applications FOR SELECT USING (true);
CREATE POLICY "Allow public insert" ON applications FOR INSERT WITH CHECK (true);
CREATE POLICY "Allow public update" ON applications FOR UPDATE USING (true);
CREATE POLICY "Allow public delete" ON applications FOR DELETE USING (true);

-- RESOURCES
ALTER TABLE resources ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Allow public select" ON resources FOR SELECT USING (true);
CREATE POLICY "Allow public insert" ON resources FOR INSERT WITH CHECK (true);
CREATE POLICY "Allow public update" ON resources FOR UPDATE USING (true);
CREATE POLICY "Allow public delete" ON resources FOR DELETE USING (true);

-- When Users enter their date of birth, we can calculate their age using a generated column. This allows us to easily query users by age without needing to calculate it on the fly each time.
-- Calculated age column for users
ALTER TABLE users ADD COLUMN age integer GENERATED ALWAYS AS (
  EXTRACT(YEAR FROM AGE(CURRENT_DATE, date_of_birth))::integer
) STORED;

-- Set Admin
UPDATE users SET is_admin = true WHERE email = 'tiffanyfam2005@gmail.com';

-- Drop if exists
DROP TABLE IF EXISTS applications;
DROP TABLE IF EXISTS opportunities;
DROP TABLE IF EXISTS resources;
DROP TABLE IF EXISTS users;