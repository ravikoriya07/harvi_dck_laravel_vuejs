<?php

namespace Database\Seeders\Data;

/**
 * Curated Indian job market seed data (no Lorem / Faker text).
 */
final class IndianJobMarketSeedData
{
    /**
     * @return list<array{name: string, slug: string}>
     */
    public static function categories(): array
    {
        return [
            ['name' => 'IT & Software', 'slug' => 'it-software'],
            ['name' => 'Accounting & Finance', 'slug' => 'accounting-finance'],
            ['name' => 'Sales & Marketing', 'slug' => 'sales-marketing'],
            ['name' => 'Human Resources (HR)', 'slug' => 'human-resources'],
            ['name' => 'Customer Support', 'slug' => 'customer-support'],
            ['name' => 'Operations', 'slug' => 'operations'],
            ['name' => 'Digital Marketing', 'slug' => 'digital-marketing'],
            ['name' => 'Banking & Insurance', 'slug' => 'banking-insurance'],
            ['name' => 'Engineering', 'slug' => 'engineering'],
            ['name' => 'Education & Training', 'slug' => 'education-training'],
        ];
    }

    /**
     * @return list<array{title: string, category_slug: string, location: string, experience: string, compensation: string, responsibilities: list<string>, requirements: list<string>}>
     */
    public static function jobs(): array
    {
        return [
            // IT & Software
            self::job('Laravel Developer', 'it-software', 'Ahmedabad', '2-4 years', '₹8-16 LPA', [
                'Design, build, and maintain web applications using Laravel and related PHP tooling.',
                'Collaborate with frontend developers and QA to ship stable releases on schedule.',
                'Write clean, testable code and participate in code reviews.',
            ], [
                'Solid experience with Laravel, PHP 8+, MySQL, REST APIs, and Git.',
                'Understanding of MVC, queues, caching, and basic DevOps (Linux, CI).',
                'Good communication skills and ability to work in an Agile team.',
            ]),
            self::job('PHP Developer', 'it-software', 'Pune', '1-3 years', '₹6-12 LPA', [
                'Develop and maintain backend services and integrations for business applications.',
                'Troubleshoot production issues and improve performance where needed.',
            ], [
                'Hands-on PHP experience with frameworks such as Laravel or Symfony.',
                'Comfortable with SQL, version control, and API integration.',
            ]),
            self::job('React.js Developer', 'it-software', 'Bangalore', '2-5 years', '₹10-20 LPA', [
                'Build responsive user interfaces with React.js and modern JavaScript tooling.',
                'Work closely with UX and backend teams to deliver end-to-end features.',
            ], [
                'Strong React fundamentals, hooks, state management, and REST/GraphQL consumption.',
                'Experience with TypeScript, testing (Jest/React Testing Library) is a plus.',
            ]),
            self::job('Full Stack Developer', 'it-software', 'Hyderabad', '3-5 years', '₹12-22 LPA', [
                'Own features across backend (Laravel/Node) and frontend (React/Vue) stacks.',
                'Support deployments, monitoring, and incident response for owned services.',
            ], [
                'Proven full stack delivery experience in a product or services company.',
                'Strong problem-solving skills and ownership mindset.',
            ]),
            self::job('DevOps Engineer', 'it-software', 'Mumbai', '3-6 years', '₹14-26 LPA', [
                'Maintain CI/CD pipelines, cloud infrastructure, and observability for engineering teams.',
                'Automate deployments and improve reliability, security, and cost efficiency.',
            ], [
                'Experience with AWS/Azure/GCP, Docker/Kubernetes, Terraform, and Linux.',
                'Scripting in Bash/Python and understanding of networking fundamentals.',
            ]),
            self::job('Mobile App Developer', 'it-software', 'Chennai', '2-4 years', '₹9-18 LPA', [
                'Develop and maintain mobile applications for Android and/or iOS platforms.',
                'Coordinate with designers and backend teams for feature delivery.',
            ], [
                'Experience with Flutter, React Native, or native Android/iOS development.',
                'Published apps or demonstrable portfolio preferred.',
            ]),

            // Accounting & Finance
            self::job('Accountant', 'accounting-finance', 'Ahmedabad', '2-4 years', '₹4-8 LPA', [
                'Maintain books of accounts, reconciliations, and month-end closing activities.',
                'Prepare GST, TDS, and related statutory filings with accuracy and timelines.',
            ], [
                'B.Com/M.Com with practical knowledge of Tally/ERP and Indian tax basics.',
                'Attention to detail and strong Excel skills.',
            ]),
            self::job('Senior Accountant', 'accounting-finance', 'Delhi NCR', '4-7 years', '₹8-14 LPA', [
                'Lead day-to-day accounting operations and mentor junior team members.',
                'Partner with auditors and management on reporting and compliance.',
            ], [
                'Experience with finalization, MIS, and indirect/direct tax compliance.',
                'CA Inter / CA Final / MBA Finance preferred.',
            ]),
            self::job('Finance Analyst', 'accounting-finance', 'Bangalore', '2-5 years', '₹9-16 LPA', [
                'Build financial models, budgets, and variance analysis for business units.',
                'Support leadership with dashboards and decision-ready insights.',
            ], [
                'Strong analytical skills and proficiency in Excel/Google Sheets.',
                'Exposure to FP&A, reporting tools, or BI is a plus.',
            ]),
            self::job('GST Specialist', 'accounting-finance', 'Surat', '3-5 years', '₹7-13 LPA', [
                'Handle GST registrations, returns, reconciliations, and audit support.',
                'Advise internal stakeholders on GST implications for transactions.',
            ], [
                'Deep understanding of GST law, e-invoicing, and portal workflows.',
                'Prior experience in industry or CA firm is preferred.',
            ]),
            self::job('Payroll Executive', 'accounting-finance', 'Pune', '1-3 years', '₹4-7 LPA', [
                'Process monthly payroll, reimbursements, and statutory deductions.',
                'Maintain employee records and respond to payroll-related queries.',
            ], [
                'Hands-on experience with payroll software and compliance basics (PF, ESI, PT).',
                'High integrity and confidentiality in handling employee data.',
            ]),

            // Sales & Marketing
            self::job('Sales Executive', 'sales-marketing', 'Mumbai', '1-3 years', '₹4-9 LPA + incentives', [
                'Generate leads, follow up on opportunities, and close deals in assigned territory.',
                'Maintain CRM hygiene and accurate sales reporting.',
            ], [
                'Strong communication, negotiation skills, and customer-first attitude.',
                'Willingness to travel locally as required.',
            ]),
            self::job('Business Development Executive', 'sales-marketing', 'Bangalore', '2-4 years', '₹6-12 LPA + incentives', [
                'Identify new business opportunities and build long-term client relationships.',
                'Coordinate with presales and delivery teams for proposals and onboarding.',
            ], [
                'B2B sales experience in IT, services, or industrial segments preferred.',
                'Comfortable with targets and pipeline management.',
            ]),
            self::job('Key Account Manager', 'sales-marketing', 'Hyderabad', '4-7 years', '₹10-18 LPA', [
                'Own revenue and relationship growth for strategic accounts.',
                'Drive upsell/cross-sell initiatives and resolve escalations professionally.',
            ], [
                'Proven account management experience with enterprise or mid-market clients.',
                'Structured problem solving and stakeholder management skills.',
            ]),
            self::job('Marketing Coordinator', 'sales-marketing', 'Chennai', '1-3 years', '₹4-8 LPA', [
                'Support campaigns, events, collateral, and partner marketing activities.',
                'Track campaign performance and share weekly summaries with leadership.',
            ], [
                'Good organizational skills and basic understanding of digital/offline marketing.',
                'Proficiency in MS Office; familiarity with Canva/Marketing tools is a plus.',
            ]),

            // Human Resources (HR)
            self::job('HR Recruiter', 'human-resources', 'Pune', '1-3 years', '₹4-8 LPA', [
                'Manage end-to-end recruitment for assigned roles across business functions.',
                'Source candidates, schedule interviews, and ensure a positive candidate experience.',
            ], [
                'Hands-on experience with Naukri/LinkedIn and applicant tracking systems.',
                'Strong communication skills and ability to manage multiple priorities.',
            ]),
            self::job('HR Executive', 'human-resources', 'Ahmedabad', '2-4 years', '₹5-9 LPA', [
                'Handle onboarding, attendance, employee queries, and HR operations.',
                'Support HR policies, engagement initiatives, and compliance documentation.',
            ], [
                'Understanding of Indian labour law basics and HR best practices.',
                'Empathetic communicator with strong documentation habits.',
            ]),
            self::job('Talent Acquisition Specialist', 'human-resources', 'Bangalore', '3-5 years', '₹8-15 LPA', [
                'Lead hiring for niche technical and leadership roles in competitive markets.',
                'Partner with hiring managers on workforce planning and employer branding.',
            ], [
                'Strong stakeholder management and deep sourcing skills.',
                'Experience hiring for IT/engineering roles is preferred.',
            ]),

            // Customer Support
            self::job('Customer Support Executive', 'customer-support', 'Jaipur', '0-2 years', '₹3-5 LPA', [
                'Respond to customer queries via phone, email, and chat with professionalism.',
                'Log tickets accurately and follow up until resolution.',
            ], [
                'Excellent verbal and written English/Hindi communication.',
                'Patience, empathy, and basic computer skills.',
            ]),
            self::job('Technical Support Engineer', 'customer-support', 'Delhi NCR', '1-3 years', '₹4-8 LPA', [
                'Diagnose technical issues, guide users, and escalate complex cases.',
                'Maintain knowledge base articles and improve first-contact resolution.',
            ], [
                'Understanding of OS, networking basics, and SaaS products.',
                'Prior experience in IT/telecom support is a plus.',
            ]),
            self::job('BPO Team Lead', 'customer-support', 'Kolkata', '3-5 years', '₹6-11 LPA', [
                'Supervise daily operations, quality, and staffing for the assigned process.',
                'Coach team members and report metrics to client stakeholders.',
            ], [
                'Prior experience in voice/email/chat processes with team handling exposure.',
                'Strong leadership and client communication skills.',
            ]),

            // Operations
            self::job('Office Administrator', 'operations', 'Surat', '1-3 years', '₹3-6 LPA', [
                'Manage front office, vendor coordination, travel, and general administration.',
                'Maintain office supplies, records, and basic facility follow-ups.',
            ], [
                'Organized multitasker with strong communication skills.',
                'Proficiency in MS Office and email etiquette.',
            ]),
            self::job('Operations Executive', 'operations', 'Mumbai', '2-4 years', '₹5-10 LPA', [
                'Coordinate daily operations workflows, SLAs, and cross-functional handoffs.',
                'Prepare operational reports and identify improvement opportunities.',
            ], [
                'Analytical mindset with exposure to process documentation and KPI tracking.',
                'Comfortable working under deadlines in a fast-paced environment.',
            ]),
            self::job('Supply Chain Coordinator', 'operations', 'Chennai', '2-5 years', '₹6-12 LPA', [
                'Track purchase orders, inventory movements, and vendor deliveries.',
                'Support logistics planning and resolve day-to-day supply issues.',
            ], [
                'Understanding of procurement/inventory basics and ERP data entry.',
                'Detail-oriented with good follow-up discipline.',
            ]),

            // Digital Marketing
            self::job('Digital Marketing Executive', 'digital-marketing', 'Bangalore', '1-3 years', '₹4-9 LPA', [
                'Execute paid and organic campaigns across Google/Meta and other channels.',
                'Monitor performance metrics and optimize creatives and targeting.',
            ], [
                'Hands-on experience with Google Ads/Meta Ads and basic analytics tools.',
                'Strong written communication for ad copy and reporting.',
            ]),
            self::job('SEO Specialist', 'digital-marketing', 'Pune', '2-4 years', '₹6-12 LPA', [
                'Improve organic visibility through technical SEO, content, and link-building best practices.',
                'Conduct keyword research, audits, and competitor analysis.',
            ], [
                'Proven SEO outcomes for websites or e-commerce properties.',
                'Familiarity with Search Console, Analytics, and common SEO tools.',
            ]),
            self::job('Social Media Manager', 'digital-marketing', 'Ahmedabad', '2-4 years', '₹5-10 LPA', [
                'Plan and publish content, community management, and campaign calendars.',
                'Coordinate with design and sales teams for launches and promotions.',
            ], [
                'Strong understanding of major social platforms and content formats.',
                'Portfolio of managed accounts/pages preferred.',
            ]),
            self::job('Content Writer', 'digital-marketing', 'Remote (India)', '1-3 years', '₹4-8 LPA', [
                'Write blogs, website copy, emailers, and case studies aligned to brand tone.',
                'Collaborate with SEO and design teams for publish-ready assets.',
            ], [
                'Excellent English writing and editing skills with attention to grammar.',
                'Ability to research B2B/B2C topics independently.',
            ]),

            // Banking & Insurance
            self::job('Relationship Manager', 'banking-insurance', 'Mumbai', '3-6 years', '₹8-16 LPA + performance pay', [
                'Acquire and deepen relationships for retail/corporate banking products.',
                'Ensure KYC/AML compliance and quality customer advisory.',
            ], [
                'Prior banking/NBFC sales or relationship experience preferred.',
                'Strong networking and presentation skills.',
            ]),
            self::job('Insurance Advisor', 'banking-insurance', 'Delhi NCR', '1-4 years', 'As per industry norms + incentives', [
                'Advise customers on suitable insurance products and complete documentation.',
                'Meet business targets while maintaining ethical sales practices.',
            ], [
                'IRDAI certification or willingness to obtain required licenses.',
                'Customer-centric approach and strong follow-up discipline.',
            ]),
            self::job('Credit Analyst', 'banking-insurance', 'Bangalore', '2-5 years', '₹9-16 LPA', [
                'Assess credit proposals, financial statements, and risk indicators.',
                'Prepare recommendation notes and support timely credit decisions.',
            ], [
                'Strong financial analysis skills and understanding of credit policy.',
                'CA/MBA Finance or relevant experience in credit underwriting.',
            ]),
            self::job('Operations Officer – Branch Banking', 'banking-insurance', 'Hyderabad', '1-3 years', '₹4-8 LPA', [
                'Handle branch operations, cash, customer service, and regulatory processes.',
                'Support audits and maintain accurate records as per bank guidelines.',
            ], [
                'Graduate with banking operations exposure preferred.',
                'High integrity and customer service orientation.',
            ]),

            // Engineering
            self::job('Civil Site Engineer', 'engineering', 'Ahmedabad', '2-5 years', '₹6-12 LPA', [
                'Supervise site execution, quality checks, and safety compliance for civil projects.',
                'Coordinate with contractors, consultants, and clients on daily progress.',
            ], [
                'B.E./Diploma in Civil Engineering with site experience.',
                'Knowledge of drawings, measurements, and basic project documentation.',
            ]),
            self::job('Electrical Engineer', 'engineering', 'Pune', '2-5 years', '₹7-14 LPA', [
                'Design support, testing, and commissioning for electrical systems and panels.',
                'Troubleshoot field issues and maintain documentation for audits.',
            ], [
                'B.E. in Electrical Engineering with relevant industry exposure.',
                'Understanding of Indian standards and safety practices.',
            ]),
            self::job('Project Engineer', 'engineering', 'Bangalore', '3-6 years', '₹10-18 LPA', [
                'Plan and monitor engineering project schedules, budgets, and deliverables.',
                'Lead coordination between design, procurement, and execution teams.',
            ], [
                'Strong project management fundamentals and stakeholder communication.',
                'Experience in industrial/infrastructure projects preferred.',
            ]),
            self::job('QA/QC Engineer', 'engineering', 'Chennai', '2-4 years', '₹6-11 LPA', [
                'Implement inspection plans, non-conformance handling, and quality documentation.',
                'Support customer and third-party audits with evidence and CAPA tracking.',
            ], [
                'Hands-on QA/QC experience in manufacturing or construction.',
                'Knowledge of ISO quality systems is a plus.',
            ]),

            // Education & Training
            self::job('Corporate Trainer', 'education-training', 'Mumbai', '3-6 years', '₹8-16 LPA', [
                'Deliver training programs on communication, leadership, or domain skills.',
                'Assess learning outcomes and continuously improve training content.',
            ], [
                'Strong facilitation skills and prior training delivery experience.',
                'Certifications in instructional design or coaching are a plus.',
            ]),
            self::job('Academic Coordinator', 'education-training', 'Hyderabad', '2-4 years', '₹5-10 LPA', [
                'Coordinate timetables, faculty schedules, student communication, and events.',
                'Maintain academic records and support admissions/enrolment activities.',
            ], [
                'Excellent coordination skills and customer handling experience.',
                'Prior experience in education institutes preferred.',
            ]),
            self::job('Instructional Designer', 'education-training', 'Bangalore', '2-5 years', '₹7-14 LPA', [
                'Design learning journeys, storyboards, and assessments for digital programs.',
                'Collaborate with SMEs and multimedia teams for high-quality courseware.',
            ], [
                'Experience with authoring tools and adult learning principles.',
                'Portfolio of learning assets is preferred.',
            ]),

            // Additional roles (still realistic, India-focused)
            self::job('.NET Developer', 'it-software', 'Delhi NCR', '2-4 years', '₹9-17 LPA', [
                'Build and maintain enterprise applications using .NET, C#, and SQL Server.',
                'Participate in design discussions, unit testing, and production support rotations.',
            ], [
                'Strong C# fundamentals and experience with ASP.NET Core Web API.',
                'Understanding of EF Core, DI, and secure coding practices.',
            ]),
            self::job('Quality Analyst', 'it-software', 'Pune', '1-3 years', '₹5-10 LPA', [
                'Design and execute test cases for web and API applications.',
                'Log defects, verify fixes, and improve regression coverage over time.',
            ], [
                'Hands-on manual testing experience; automation basics are a plus.',
                'Structured documentation habits and clear communication with developers.',
            ]),
            self::job('Inside Sales Representative', 'sales-marketing', 'Bangalore', '1-3 years', '₹5-9 LPA + incentives', [
                'Qualify inbound leads, run discovery calls, and schedule meetings for field sales.',
                'Maintain accurate CRM notes and follow defined sales playbooks.',
            ], [
                'Excellent phone/email communication and listening skills.',
                'Comfortable working with targets in a metrics-driven environment.',
            ]),
            self::job('Product Marketing Associate', 'sales-marketing', 'Hyderabad', '2-4 years', '₹7-13 LPA', [
                'Support positioning, launch assets, competitor benchmarking, and sales enablement.',
                'Coordinate with product, sales, and creative teams for campaigns.',
            ], [
                'Strong written communication and interest in B2B technology marketing.',
                'Prior internship or full-time marketing experience preferred.',
            ]),
            self::job('Warehouse Supervisor', 'operations', 'Chennai', '3-5 years', '₹5-9 LPA', [
                'Supervise inbound/outbound operations, inventory accuracy, and safety compliance.',
                'Train warehouse staff and report daily productivity and exceptions.',
            ], [
                'Experience in logistics/warehouse operations with team lead exposure.',
                'Basic MS Excel skills and familiarity with WMS/ERP scanning workflows.',
            ]),
            self::job('Claims Processor', 'banking-insurance', 'Kolkata', '1-3 years', '₹4-7 LPA', [
                'Review insurance claims documents, validate policy coverage, and process payouts.',
                'Coordinate with surveyors/customers for missing information and timely closure.',
            ], [
                'Good attention to detail and ability to follow documented claim procedures.',
                'Prior experience in insurance operations or back-office processing preferred.',
            ]),
        ];
    }

    /**
     * @param  list<string>  $responsibilities
     * @param  list<string>  $requirements
     * @return array{title: string, category_slug: string, location: string, experience: string, compensation: string, responsibilities: list<string>, requirements: list<string>}
     */
    private static function job(
        string $title,
        string $categorySlug,
        string $location,
        string $experience,
        string $compensation,
        array $responsibilities,
        array $requirements,
    ): array {
        return [
            'title' => $title,
            'category_slug' => $categorySlug,
            'location' => $location,
            'experience' => $experience,
            'compensation' => $compensation,
            'responsibilities' => $responsibilities,
            'requirements' => $requirements,
        ];
    }

    /**
     * @param  array{title: string, category_slug: string, location: string, experience: string, compensation: string, responsibilities: list<string>, requirements: list<string>}  $job
     */
    public static function formatDescription(array $job): string
    {
        $resp = collect($job['responsibilities'])->map(fn (string $line): string => '• '.$line)->implode("\n");
        $req = collect($job['requirements'])->map(fn (string $line): string => '• '.$line)->implode("\n");

        return <<<TXT
Location: {$job['location']}
Experience: {$job['experience']}
Compensation: {$job['compensation']}

Responsibilities:
{$resp}

Requirements:
{$req}
TXT;
    }
}
