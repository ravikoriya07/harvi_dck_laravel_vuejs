<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [

            // ── 01 ───────────────────────────────────────────────────────────
            [
                'title'    => 'London Borough of Haringey - Kitchen & Bathroom Refurbishment',
                'category' => 'Refurbishment',
                'slug'     => 'london-borough-of-haringey-kitchen-bathroom-refurbishment',
                'image'    => '/assets/images/DCK-Northumberland-Park-15-3-600x600.png',
                'value'    => '£2.4 million',
                'date'     => 'March 2022',
                'status'   => 'Completed',
                'client'   => 'London Borough of Haringey',
                'scope'    => 'Full strip-out and replacement of kitchens and bathrooms across 180 occupied residential properties, including new fitted units, sanitaryware, tiling, and associated mechanical and electrical works.',
                'description' => '<h3>Project Description</h3>
<p>DCK was appointed by the London Borough of Haringey to deliver a comprehensive kitchen and bathroom refurbishment programme across occupied residential properties within the borough. The contract was secured through a competitive tender process on the council\'s Dynamic Purchasing System (DPS).</p>
<p>The scope of works includes full strip-out and replacement of all kitchen and bathroom fittings, including new fitted units, worktops, sink, sanitaryware, tiling, and associated plumbing and electrical upgrades. All installations comply with current Building Regulations and the council\'s specification standards.</p>
<p>DCK\'s directly employed workforce manages all trades in-house, ensuring rigorous quality control, minimal disruption to residents, and timely programme delivery. A dedicated resident liaison officer was assigned to the contract, maintaining clear communication throughout the works and addressing any concerns promptly.</p>
<p>The programme delivered significant improvements to the living standards of residents across Haringey. Social value commitments included the creation of local employment opportunities and engagement with community initiatives, reflecting DCK\'s commitment to delivering value beyond the contract itself.</p>',
                'gallery'  => [
                    '/assets/images/DCK-Northumberland-Park-15-3-600x600.png',
                ],
            ],

            // ── 02 ───────────────────────────────────────────────────────────
            [
                'title'    => 'LB Haringey - Void Refurbishment',
                'category' => 'Refurbishment',
                'slug'     => 'lb-haringey-void-refurbishment',
                'image'    => '/assets/images/WhatsApp-Image-2025-09-25-at-15.46.02_0bb1e965-600x600.jpg',
                'value'    => '£1.6 million',
                'date'     => 'September 2022',
                'status'   => 'Completed',
                'client'   => 'London Borough of Haringey',
                'scope'    => 'Full void property refurbishment across 95 properties including plastering, decoration, kitchen and bathroom replacement, electrical upgrades, boiler servicing, and external works.',
                'description' => '<h3>Project Description</h3>
<p>DCK delivered a rolling void refurbishment programme for the London Borough of Haringey, bringing empty residential properties back to a lettable standard as quickly and efficiently as possible. The programme was designed to minimise void periods and reduce the financial impact on the council\'s housing stock.</p>
<p>Each property received a comprehensive condition survey on handover, with works scoped accordingly. Standard works included full internal redecoration, kitchen and bathroom replacement where required, plumbing and electrical testing and remediation, boiler servicing and replacement, floor finishes, and joinery repairs.</p>
<p>DCK\'s rapid-response approach and on-site management ensured properties were turned around well within the council\'s target timescales. The team coordinated closely with the council\'s housing management team and contractors to manage the programme across multiple sites simultaneously.</p>
<p>The programme contributed directly to reducing Haringey\'s housing waiting list by returning quality homes to available stock, while DCK\'s social value commitments provided local employment and apprenticeship opportunities across the borough.</p>',
                'gallery'  => [
                    '/assets/images/WhatsApp-Image-2025-09-25-at-15.46.02_0bb1e965-600x600.jpg',
                ],
            ],

            // ── 03 ───────────────────────────────────────────────────────────
            [
                'title'    => 'LB Hackney - Void Full Refurbishment Programme',
                'category' => 'Refurbishment',
                'slug'     => 'lb-hackney-void-full-refurbishment-programme',
                'image'    => '/assets/images/WhatsApp-Image-2025-09-25-at-15.45.01_27d90c71-600x600.jpg',
                'value'    => '£2.2 million',
                'date'     => 'January 2023',
                'status'   => 'Completed',
                'client'   => 'London Borough of Hackney',
                'scope'    => 'Comprehensive void refurbishment programme covering full internal strip-out, structural repairs, kitchen and bathroom installation, new electrical and heating systems, and complete internal redecoration across 120 properties.',
                'description' => '<h3>Project Description</h3>
<p>DCK was appointed by the London Borough of Hackney to undertake a full void refurbishment programme across its social housing portfolio. The contract required DCK to deliver high-quality, compliant refurbishments within tight turnaround timescales to minimise void periods and reduce re-let times.</p>
<p>Works encompassed a full range of trades, including structural repairs, plastering and rendering, complete internal redecoration, kitchen and bathroom replacement, new boilers and heating systems, full electrical rewires where necessary, and the installation of new floor finishes throughout.</p>
<p>DCK employed a co-ordinated project management approach, with dedicated site managers overseeing multiple concurrent properties. Regular reporting to the council\'s asset management team ensured full visibility of programme progress and any variations to scope were managed efficiently.</p>
<p>All works were carried out in compliance with the council\'s specification and current Building Regulations. DCK\'s commitment to quality assurance included post-works inspections and a snagging process prior to handover, ensuring properties met the required lettable standard on first inspection.</p>',
                'gallery'  => [
                    '/assets/images/WhatsApp-Image-2025-09-25-at-15.45.01_27d90c71-600x600.jpg',
                ],
            ],

            // ── 04 ───────────────────────────────────────────────────────────
            [
                'title'    => 'Extension and Refurbishment Project | LB Haringey',
                'category' => 'Refurbishment',
                'slug'     => 'extension-and-refurbishment-project-lb-haringey',
                'image'    => '/assets/images/WhatsApp-Image-2025-09-25-at-15.41.48_402f275d-600x600.jpg',
                'value'    => '£850,000',
                'date'     => 'April 2023',
                'status'   => 'Completed',
                'client'   => 'London Borough of Haringey',
                'scope'    => 'Single-storey rear extension and full internal refurbishment of a residential property, including structural works, new kitchen and bathroom, full redecoration, and external landscaping.',
                'description' => '<h3>Project Description</h3>
<p>DCK was commissioned by the London Borough of Haringey to deliver a combined extension and refurbishment project at a residential property within the borough. The project involved the design and construction of a new single-storey rear extension to create additional habitable space, alongside a comprehensive refurbishment of the existing property.</p>
<p>The extension works included groundworks and foundations, structural steelwork, masonry construction, new roof, windows and external doors, insulation, and full internal fit-out. The refurbishment scope covered full internal redecoration, new kitchen and bathroom, replacement flooring, electrical upgrades, and new heating controls throughout.</p>
<p>DCK worked closely with the council\'s planning and building control teams to ensure all elements of the project received the necessary approvals and complied with current Building Regulations. The design incorporated energy-efficiency measures including upgraded insulation, double-glazing, and a high-efficiency boiler.</p>
<p>The project was completed on programme and within budget, delivering a significantly improved residential property that meets modern standards of comfort, energy efficiency, and accessibility.</p>',
                'gallery'  => [
                    '/assets/images/WhatsApp-Image-2025-09-25-at-15.41.48_402f275d-600x600.jpg',
                ],
            ],

            // ── 05 ───────────────────────────────────────────────────────────
            [
                'title'    => 'Haringey Aids & Adaptations Works',
                'category' => 'Aids and adaptations',
                'slug'     => 'haringey-aids-adaptations-works',
                'image'    => '/assets/images/6509ab55-97be-4536-9747-018df8c0a9f5-600x600.jpg',
                'value'    => '£1.1 million',
                'date'     => 'October 2022',
                'status'   => 'Ongoing',
                'client'   => 'London Borough of Haringey',
                'scope'    => 'Design, supply and installation of aids and adaptations including level-access showers, stairlifts, grab rails, ramp access, widened doorways, and specialist equipment across occupied residential properties for vulnerable and disabled residents.',
                'description' => '<h3>Project Description</h3>
<p>DCK holds a term contract with the London Borough of Haringey for the delivery of aids and adaptations works to occupied social housing properties across the borough. The programme supports vulnerable residents — including elderly people, those living with disabilities, and individuals recovering from illness or injury — to remain safely and independently in their own homes.</p>
<p>Works are delivered in response to referrals from Haringey\'s Occupational Therapy team and include a wide range of adaptations tailored to individual residents\' assessed needs. Typical works include the installation of level-access wet rooms and walk-in showers, stairlifts, through-floor lifts, grab rails and handrails, external ramps and dropped kerbs, widened doorways, and specialised kitchen adaptations.</p>
<p>DCK\'s Aids and Adaptations team operates with a sensitive and person-centred approach, recognising that works are carried out in residents\' homes. Appointments are scheduled to minimise disruption, and a dedicated site supervisor ensures each job is carried out to the highest standard and handed over with all necessary demonstrations and documentation.</p>
<p>The contract operates on an open-book basis, with transparent pricing and full reporting to the council on a monthly basis. DCK\'s performance is measured against KPIs including appointment satisfaction, completion on time, and first-time fix rates, all of which consistently exceed the council\'s targets.</p>',
                'gallery'  => [
                    '/assets/images/6509ab55-97be-4536-9747-018df8c0a9f5-600x600.jpg',
                ],
            ],

            // ── 06 ───────────────────────────────────────────────────────────
            [
                'title'    => 'Harrow Aids & Adaptations Works',
                'category' => 'Aids and adaptations',
                'slug'     => 'harrow-aids-adaptations-works',
                'image'    => '/assets/images/0ab4bbf9-2f9c-42f1-b604-0c4230f95d6a-600x600.jpg',
                'value'    => '£900,000',
                'date'     => 'July 2023',
                'status'   => 'Ongoing',
                'client'   => 'London Borough of Harrow',
                'scope'    => 'Provision and installation of a full range of aids and adaptations including wet rooms, stairlifts, ramp access, grab rails, and specialist equipment for disabled and elderly residents across the London Borough of Harrow.',
                'description' => '<h3>Project Description</h3>
<p>DCK was appointed by the London Borough of Harrow to deliver a comprehensive aids and adaptations programme across the borough\'s social housing stock. The contract supports the council\'s commitment to enabling vulnerable residents to live independently and safely within their own homes.</p>
<p>Works are carried out following referrals from Harrow\'s Occupational Therapy service and cover a broad spectrum of adaptations based on individual needs assessments. The programme includes installation of level-access showers and wet rooms, stairlift and through-floor lift supply and installation, external ramp construction, doorway widening, grab rail and handrail installation, and specialist kitchen and bathroom adaptations.</p>
<p>DCK operates a responsive service, attending properties within agreed timescales and ensuring all works are completed to a high standard with minimum disruption to residents. Each project is managed by an experienced supervisor who ensures compliance with the specification, Building Regulations, and the council\'s quality standards.</p>
<p>All completed works are signed off by the council\'s Occupational Therapy team following a post-completion inspection. DCK\'s track record on this contract has resulted in consistently high resident satisfaction scores and strong performance against all contractual KPIs.</p>',
                'gallery'  => [
                    '/assets/images/0ab4bbf9-2f9c-42f1-b604-0c4230f95d6a-600x600.jpg',
                ],
            ],

            // ── 07 ───────────────────────────────────────────────────────────
            [
                'title'    => 'Aids & Adaptations, London Borough of Haringey',
                'category' => 'Aids and adaptations',
                'slug'     => 'aids-adaptations-london-borough-of-haringey',
                'image'    => '/assets/images/LAS1-1-600x600.jpg',
                'value'    => '£750,000',
                'date'     => 'February 2022',
                'status'   => 'Completed',
                'client'   => 'London Borough of Haringey',
                'scope'    => 'Targeted aids and adaptations programme delivering specialist installations across 200+ properties for elderly and disabled residents, including wet rooms, stairlifts, and access improvements.',
                'description' => '<h3>Project Description</h3>
<p>This aids and adaptations contract was delivered by DCK on behalf of the London Borough of Haringey as part of the council\'s programme to support residents with disabilities and age-related conditions to remain in their homes safely. Works were delivered following referrals from the council\'s Adult Social Care and Occupational Therapy teams.</p>
<p>The contract covered a wide range of adaptations including level-access shower and wet room installations, stairlifts and through-floor platform lifts, external access ramps and path improvements, grab rail and handrail installations, door widening and threshold levelling, and specialist bathroom and kitchen modifications.</p>
<p>DCK\'s approach prioritised the wellbeing and comfort of residents throughout the works process. Site supervisors maintained close communication with residents and their carers, and works were scheduled to minimise any disruption to daily routines. Completed installations were demonstrated to residents and any support documentation was provided at handover.</p>
<p>The programme was delivered on time and within budget, achieving high resident satisfaction scores throughout. DCK\'s performance on this contract contributed directly to residents\' quality of life, independence, and safety in their homes.</p>',
                'gallery'  => [
                    '/assets/images/LAS1-1-600x600.jpg',
                ],
            ],

            // ── 08 ───────────────────────────────────────────────────────────
            [
                'title'    => 'Southwark Void Refurbishment Programme 2025',
                'category' => 'Construction',
                'slug'     => 'southwark-void-refurbishment-programme-2025',
                'image'    => '/assets/images/Untitled-design-1-1-600x600.png',
                'value'    => '£3.1 million',
                'date'     => 'January 2025',
                'status'   => 'In Progress',
                'client'   => 'London Borough of Southwark',
                'scope'    => 'Large-scale void refurbishment programme covering 160+ properties across Southwark, including full internal strip-outs, kitchen and bathroom replacements, M&E upgrades, structural repairs, and full redecoration.',
                'description' => '<h3>Project Description</h3>
<p>DCK was awarded the Southwark Void Refurbishment Programme 2025 by the London Borough of Southwark following a competitive procurement process. The programme represents one of DCK\'s largest current contracts and demonstrates the company\'s capability to manage high-volume, multi-site operations across a large local authority portfolio.</p>
<p>The programme covers a rolling series of void refurbishments across the borough\'s social housing stock. Each property is assessed on receipt and works are scoped individually based on condition, with a standard specification forming the basis for all completions. Works include full internal strip-outs, structural and fabric repairs, plastering and rendering, new kitchens and bathrooms, electrical rewires and consumer unit replacement, new heating systems, floor finishes, and comprehensive redecoration.</p>
<p>DCK employs a dedicated project management team for the Southwark programme, with a contract manager, multiple site supervisors, and a planning team coordinating the workflow across all active sites. Reporting to the council includes weekly progress updates, KPI dashboards, and financial reporting.</p>
<p>The programme is currently in progress and on track to deliver all properties within the council\'s target timescales. DCK\'s social value plan for the contract includes employment of Southwark residents, apprenticeship opportunities, and contributions to local community projects.</p>',
                'gallery'  => [
                    '/assets/images/Untitled-design-1-1-600x600.png',
                ],
            ],

            // ── 09 ───────────────────────────────────────────────────────────
            [
                'title'    => 'Extension Project, Cuffley',
                'category' => 'Construction',
                'slug'     => 'extension-project-cuffley',
                'image'    => '/assets/images/main-600x600.jpeg',
                'value'    => '£420,000',
                'date'     => 'August 2022',
                'status'   => 'Completed',
                'client'   => 'Private Client',
                'scope'    => 'Design and build of a two-storey side and single-storey rear extension to a detached residential property, including structural works, new roof, full internal fit-out, and landscaping.',
                'description' => '<h3>Project Description</h3>
<p>DCK was appointed by a private client to design and construct a substantial extension to their detached residential property in Cuffley, Hertfordshire. The project comprised a two-storey side extension and a single-storey rear extension, adding significant additional habitable space to the existing property.</p>
<p>The works involved full groundworks and concrete foundations, load-bearing structural steelwork, cavity wall masonry construction, new pitched and flat roof elements, replacement windows and external doors, and full internal fit-out including insulation, plasterboarding, plastering, and first-fix and second-fix carpentry.</p>
<p>Internal works included the installation of a new open-plan kitchen and dining area within the rear extension, two additional bedrooms and a family bathroom within the side extension, full redecoration throughout, and the fitting of new floor finishes. Mechanical and electrical works covered new central heating, new electrical circuits, and the integration of smart home technology.</p>
<p>The project required close coordination with the local planning authority and building control. DCK managed all aspects of the project from pre-construction through to final handover, including procurement, site management, and quality assurance, delivering a result that the client was delighted with.</p>',
                'gallery'  => [
                    '/assets/images/main-600x600.jpeg',
                ],
            ],

            // ── 10 ──────────────────────────────────────────────────────────
            [
                'title'    => 'Seething Wells Campus, Kingston University',
                'category' => 'Construction',
                'slug'     => 'seething-wells-campus-kingston-university',
                'image'    => '/assets/images/IMG1-1-1-600x600.png',
                'value'    => '£4.8 million',
                'date'     => 'June 2021',
                'status'   => 'Completed',
                'client'   => 'Kingston University',
                'scope'    => 'Major refurbishment and reconfiguration of student accommodation blocks at the Seething Wells campus, including roofing, external envelope works, full internal fit-out of en-suite study bedrooms, communal facilities, and M&E upgrades.',
                'description' => '<h3>Project Description</h3>
<p>DCK was appointed by Kingston University to undertake a major refurbishment and reconfiguration of the Seething Wells student accommodation campus in Kingston upon Thames, Surrey. The project transformed the existing accommodation to provide high-quality en-suite study bedrooms and improved communal facilities for students.</p>
<p>The refurbishment scope covered the full external envelope including roof replacement, external wall insulation and render, new windows and external doors, and associated external works. Internally, the works involved full strip-out, new partition layouts, en-suite bathroom installations, new flooring, ceilings, and redecoration throughout all study bedrooms and communal areas.</p>
<p>Mechanical and electrical works included full rewiring, new data and communication infrastructure, new heating and hot water systems, fire detection and alarm upgrades, and new ventilation systems throughout. All works were designed and installed to meet current Building Regulations and the university\'s specification.</p>
<p>The project was delivered during summer vacation periods to minimise disruption to students, requiring careful phasing and programme management. DCK worked closely with the university\'s estates team to ensure the accommodation was available for occupation at the start of the new academic year. The completed project received excellent feedback from university management and students alike.</p>',
                'gallery'  => [
                    '/assets/images/IMG1-1-1-600x600.png',
                ],
            ],

            // ── 11 ──────────────────────────────────────────────────────────
            [
                'title'    => 'Seafront Hotel, Brighton',
                'category' => 'Construction',
                'slug'     => 'seafront-hotel-brighton',
                'image'    => '/assets/images/Untitled-design-2-1-600x600.png',
                'value'    => '£2.7 million',
                'date'     => 'November 2022',
                'status'   => 'Completed',
                'client'   => 'Private Hospitality Client',
                'scope'    => 'Full internal refurbishment of a 4-star seafront hotel including all 85 guest bedrooms and suites, restaurant and bar areas, lobby and reception, back-of-house facilities, and full M&E upgrade works.',
                'description' => '<h3>Project Description</h3>
<p>DCK delivered a comprehensive refurbishment of a well-established seafront hotel in Brighton on behalf of a private hospitality client. The project involved a full internal renovation to bring the hotel up to modern 4-star standards while retaining the character and charm of the existing building.</p>
<p>The refurbishment covered all 85 guest bedrooms and suites, receiving new soft furnishings, remodelled en-suite bathrooms, new floor finishes, ceiling treatments, and full redecoration. Bedroom technology upgrades included new TV systems, USB charging points, and improved Wi-Fi infrastructure throughout.</p>
<p>Public areas including the restaurant, bar, lounge, and lobby were fully refurbished with new furniture, fittings, and finishes, creating a fresh and contemporary guest experience. Back-of-house areas including staff facilities, laundry, and kitchen infrastructure were also upgraded as part of the programme.</p>
<p>Mechanical and electrical works included replacement of the heating and hot water infrastructure, new electrical distribution, fire alarm upgrade, emergency lighting, and improvements to the ventilation system throughout. The project was carefully phased to allow the hotel to remain partially operational during the works, minimising the impact on trading and revenue.</p>',
                'gallery'  => [
                    '/assets/images/Untitled-design-2-1-600x600.png',
                ],
            ],

            // ── 12 ──────────────────────────────────────────────────────────
            [
                'title'    => 'Great Arthur House, City of London',
                'category' => 'Construction',
                'slug'     => 'great-arthur-house-city-of-london',
                'image'    => '/assets/images/image_3-7-1-600x600.png',
                'value'    => '£5.2 million',
                'date'     => 'March 2023',
                'status'   => 'Completed',
                'client'   => 'City of London Corporation',
                'scope'    => 'Major external and internal refurbishment of a 16-storey residential tower block including full external envelope replacement, cladding, window replacement, communal area refurbishment, fire safety upgrades, and new lift installations.',
                'description' => '<h3>Project Description</h3>
<p>DCK was appointed by the City of London Corporation to undertake a major refurbishment of Great Arthur House, a 16-storey residential tower block located within the Golden Lane Estate. The project encompassed significant works to both the external envelope and the internal communal areas of the building.</p>
<p>External works included the full replacement of the building\'s cladding system in compliance with current fire safety regulations, new double-glazed window and door systems, external decorations, and associated scaffolding and access works. The envelope upgrade significantly improved the building\'s thermal performance and dramatically transformed its appearance.</p>
<p>Internal communal works included full refurbishment of all stairwells, lift lobbies, and communal corridors, including new floor finishes, wall and ceiling treatments, lighting upgrades, and wayfinding signage. Two new passenger lifts were installed to replace the existing aging infrastructure, improving accessibility and reliability for residents.</p>
<p>Fire safety works formed a significant element of the contract, including the installation of a new fire detection and alarm system throughout, fire door replacements throughout the building, installation of dry rising mains, and smoke ventilation improvements. All works were carried out in accordance with current fire safety legislation and the building\'s fire risk assessment. The project was completed on programme, with residents remaining in occupation throughout.</p>',
                'gallery'  => [
                    '/assets/images/image_3-7-1-600x600.png',
                ],
            ],

            // ── 13 ──────────────────────────────────────────────────────────
            [
                'title'    => 'Haringey Broadwater Farm Estate Fire Safety Works & Communal Decorations',
                'category' => 'Construction',
                'slug'     => 'designer-apartment',
                'image'    => '/assets/images/JOB-70-of-155-scaled-600x600.jpg',
                'value'    => '£3.5 million',
                'date'     => 'November 2023',
                'status'   => 'Completed in 2024',
                'client'   => 'London Borough of Haringey',
                'scope'    => '983 new fire doors, 336 fire-rated riser access panels, new detection systems in communal areas, associated electrical works, extensive communal decorations, improved signage and new spandrel panels.',
                'description' => '<h3>Project Description</h3>
<p>DCK secured this contract via an open competitive tender on the council\'s Dynamic Purchasing System (DPS). The works involved in this project are deemed to be essential to ensure the buildings adequately provide a suitable means of escape in the event of fire and separation between the dwellings and the communal areas.</p>
<p>The works include the replacement of flat entrance doors (FEDs), cross-corridor and stairwell doors, and riser cupboard doors. Works also include extensive communal decorations, improved wayfinding signage in accordance with The Fire Safety (England) Regulations 2022, installation of L4 detection systems in communal areas, and replacement of emergency lighting as and where required.</p>
<p>The cross-corridor doors also include hold-open devices linked to individual detectors. The works will ensure the blocks are compliant with the current Fire Safety and Building Safety Regulations.</p>
<p>DCK, holding the bmtrada certification to install fire doors, will install 655 FEDs and 328 communal doors, in addition to the 336, one-hour fire-rated riser access panels over six months with its own directly employed workforce. The FED specification is for an FD30S door, with FD60S doors specified in communal areas.</p>
<p>Whilst the design and the range of colour choices of the doors will be set by the council, residents will have a choice of door colour to complement the new wall decorations. Of the 655 flats to receive a new FED, 91 are occupied by leaseholders.</p>
<p>DCK has committed to a range of social value activities that include providing new jobs for residents, a pledge to spend at least £280,000 with locally based businesses, and supporting local community-based organisations with donations and resources to undertake events and projects that will benefit the local community.</p>',
                'gallery'  => [
                    '/assets/images/projects/2/JOB-18-of-155-scaled.jpg',
                    '/assets/images/projects/2/JOB-1-of-155-1-scaled.jpg',
                    '/assets/images/projects/2/JOB-104-of-155-scaled.jpg',
                    '/assets/images/projects/2/JOB-62-of-155-scaled.jpg',
                    '/assets/images/projects/2/JOB-24-of-155-scaled.jpg',
                ],
            ],

            // ── 14 ──────────────────────────────────────────────────────────
            [
                'title'    => 'Haringey Broadwater Farm Community Centre',
                'category' => 'Construction',
                'slug'     => 'haringey-broadwater-farm-community-centre',
                'image'    => '/assets/images/projects/1/DCK-Broadwater-Farm-Community-Project-01-600x600.png',
                'value'    => '£1.9 million',
                'date'     => 'May 2022',
                'status'   => 'Completed',
                'client'   => 'London Borough of Haringey',
                'scope'    => 'Full refurbishment and modernisation of the Broadwater Farm Community Centre including structural repairs, new roof, full internal fit-out, M&E upgrades, new accessible entrance, and external landscaping.',
                'description' => '<h3>Project Description</h3>
<p>DCK was appointed by the London Borough of Haringey to refurbish and modernise the Broadwater Farm Community Centre, an important community asset at the heart of the Broadwater Farm Estate in Tottenham, North London. The project aimed to restore and upgrade the facility to serve the community for years to come.</p>
<p>The works included structural repairs to the building fabric, replacement of the existing flat roof with a new high-performance system, full external redecoration, and improvements to the building\'s external appearance and landscaping. A new accessible main entrance was created to ensure the facility is fully inclusive for all users.</p>
<p>Internal works included full strip-out and refurbishment of all activity rooms, the main hall, kitchen facilities, toilets and changing rooms, and office accommodation. New flooring, ceilings, wall finishes, and joinery were installed throughout, and the full internal decoration was completed in a fresh, modern palette.</p>
<p>Mechanical and electrical works included new LED lighting throughout, a new heating and hot water system, ventilation improvements, full electrical upgrade, and a new fire detection and alarm system. The project was delivered with the centre remaining partially operational, requiring careful phasing and close communication with centre management and users throughout the programme.</p>',
                'gallery'  => [
                    '/assets/images/projects/1/DCK-Broadwater-Farm-Community-Project-01-600x600.png',
                ],
            ],

            // ── 15 ──────────────────────────────────────────────────────────
            [
                'title'    => 'Void Property Renovations, London Borough of Haringey',
                'category' => 'Construction',
                'slug'     => 'void-property-renovations-london-borough-of-haringey',
                'image'    => '/assets/images/WhatsApp-Image-2025-09-25-at-15.37.48_3369e48e-600x600.jpg',
                'value'    => '£1.3 million',
                'date'     => 'August 2023',
                'status'   => 'Completed',
                'client'   => 'London Borough of Haringey',
                'scope'    => 'Void property renovation programme across 70 residential units including structural repairs, full internal refurbishment, kitchen and bathroom replacement, and complete redecoration to bring properties to a lettable standard.',
                'description' => '<h3>Project Description</h3>
<p>DCK delivered a targeted void property renovation programme for the London Borough of Haringey, addressing a backlog of void properties that required significant works before being available for re-letting. The programme was designed to reduce the council\'s void stock and improve the quality of homes available to residents on the housing register.</p>
<p>Each property was surveyed and individually scoped on handover to DCK. Works ranged from minor decorative repairs on lower-condition voids, through to full refurbishments involving structural repairs, damp treatment, complete replastering, full kitchen and bathroom replacement, electrical upgrades, boiler replacement, and comprehensive redecoration.</p>
<p>DCK\'s site management team operated a clear workflow system to manage multiple properties concurrently, ensuring efficient use of resources and consistent delivery against the council\'s target turnaround times. Regular progress meetings with the council\'s housing management team ensured full transparency throughout the programme.</p>
<p>The programme was delivered on time and within budget, achieving average void turnaround times significantly below the council\'s target, and contributing to a meaningful reduction in Haringey\'s void stock. Post-completion inspections confirmed all properties met the council\'s required lettable standard prior to handover.</p>',
                'gallery'  => [
                    '/assets/images/WhatsApp-Image-2025-09-25-at-15.37.48_3369e48e-600x600.jpg',
                ],
            ],

            // ── 16 ──────────────────────────────────────────────────────────
            [
                'title'    => 'Void Property Renovations, Ministry of Defence',
                'category' => 'Construction',
                'slug'     => 'void-property-renovations-ministry-of-defence',
                'image'    => '/assets/images/main-9-600x600.jpg',
                'value'    => '£2.8 million',
                'date'     => 'April 2022',
                'status'   => 'Completed',
                'client'   => 'Ministry of Defence',
                'scope'    => 'Void renovation programme across 140 MoD residential properties, including full internal refurbishment, fabric repairs, kitchen and bathroom replacement, M&E upgrades, and external works to bring properties to a habitable standard for service personnel.',
                'description' => '<h3>Project Description</h3>
<p>DCK was appointed by the Ministry of Defence to deliver a void renovation programme across its residential property portfolio. The contract required DCK to bring a portfolio of void service family accommodation properties up to the required standard for occupation by military personnel and their families.</p>
<p>Each property received a detailed condition survey on handover and works were scoped to meet the MoD\'s published accommodation standards. Standard refurbishments included full internal decoration, kitchen and bathroom replacement to the MoD\'s specification, new floor finishes, electrical and heating system testing and remediation, and external works including fencing, gardens, and driveways where required.</p>
<p>Higher-condition voids received more extensive works including structural repairs, replastering, full rewires, boiler replacements, and new windows and doors. DCK\'s experienced site teams managed the full range of refurbishment works using directly employed tradespeople supplemented by specialist subcontractors for elements such as roofing and specialist flooring.</p>
<p>The programme was delivered to a demanding programme, with DCK achieving average completion times within the MoD\'s target void turnaround periods. Quality assurance was maintained throughout via independent post-works inspections, and DCK\'s performance consistently met or exceeded the contract KPIs across all measured categories.</p>',
                'gallery'  => [
                    '/assets/images/main-9-600x600.jpg',
                ],
            ],

            // ── 17 ──────────────────────────────────────────────────────────
            [
                'title'    => 'Kitchens & Bathrooms, London Borough of Haringey',
                'category' => 'Construction',
                'slug'     => 'kitchens-bathrooms-london-borough-of-haringey',
                'image'    => '/assets/images/5-3-600x600.png',
                'value'    => '£1.7 million',
                'date'     => 'January 2023',
                'status'   => 'Completed',
                'client'   => 'London Borough of Haringey',
                'scope'    => 'Planned kitchen and bathroom replacement programme across 100 occupied residential properties, including full strip-out, new fitted units, sanitaryware, tiling, floor finishes, and associated plumbing and electrical works.',
                'description' => '<h3>Project Description</h3>
<p>DCK delivered this planned kitchen and bathroom replacement programme for the London Borough of Haringey as part of the council\'s ongoing investment in the quality and condition of its residential housing stock. The contract was procured through a competitive framework arrangement and built on DCK\'s established relationship with the council.</p>
<p>Works were carried out in occupied properties with residents remaining in their homes throughout. The programme required careful planning and coordination to minimise disruption, including pre-works surveys, early notification to residents, and a structured appointment booking system to manage resident expectations and ensure efficient site operations.</p>
<p>Kitchen works included full strip-out of existing fittings, making good to walls and floor, installation of new base and wall units, worktops, sink and taps, new floor finishes, tiling, and plumbing and electrical connections. Bathroom works included full strip-out, new sanitaryware (bath or shower enclosure, WC, basin), full tiling, new floor finishes, and associated plumbing and electrical connections.</p>
<p>All materials were selected from the council\'s approved schedule of rates and sourced from approved suppliers. DCK\'s quality management process included pre-works, mid-works, and post-works inspections by site supervisors, ensuring all completions met the required standard before handover to residents.</p>',
                'gallery'  => [
                    '/assets/images/5-3-600x600.png',
                ],
            ],

            // ── 18 ──────────────────────────────────────────────────────────
            [
                'title'    => 'Haringey Kitchens & Bathrooms 2024 Programme',
                'category' => 'Construction',
                'slug'     => 'haringey-kitchens-bathrooms-2024-programme',
                'image'    => '/assets/images/71bfe462-bc1a-4842-8e7e-abbe413f4e59-600x600.jpg',
                'value'    => '£2.0 million',
                'date'     => 'March 2024',
                'status'   => 'In Progress',
                'client'   => 'London Borough of Haringey',
                'scope'    => 'Annual planned kitchen and bathroom replacement programme for 2024, covering 115 properties across multiple Haringey estates with new fitted kitchens, bathrooms, tiling, floor finishes, and associated M&E works.',
                'description' => '<h3>Project Description</h3>
<p>DCK is currently delivering the 2024 Kitchen and Bathroom Programme for the London Borough of Haringey, the latest in a series of annual planned investment programmes that DCK has delivered for the council. The programme represents a significant investment in Haringey\'s residential housing stock and demonstrates the council\'s continued confidence in DCK as a delivery partner.</p>
<p>The 2024 programme covers 115 properties across multiple estates within the borough, with works phased across the year to manage occupant disruption and maintain a consistent workflow. Each property receives a pre-works survey to confirm the scope and identify any additional requirements not anticipated within the standard specification.</p>
<p>Kitchen works include full strip-out, making good, new fitted units to the council\'s current specification, worktops, sink and taps, splashback tiling, floor finishes, and plumbing and electrical connections. Bathroom works include full strip-out, new sanitaryware, full tiling, floor finishes, and plumbing and electrical connections, with the option for either a bath or walk-in shower configuration depending on property layout and resident preference.</p>
<p>The programme is progressing well and on track to complete all 115 properties within the 2024/25 financial year. DCK\'s resident engagement approach ensures residents are fully informed throughout and any specific requirements are accommodated within the programme\'s constraints.</p>',
                'gallery'  => [
                    '/assets/images/71bfe462-bc1a-4842-8e7e-abbe413f4e59-600x600.jpg',
                ],
            ],

            // ── 19 ──────────────────────────────────────────────────────────
            [
                'title'    => 'Haringey Community Benefit Society (HCBS) Voids Refurbishment Works',
                'category' => 'Construction',
                'slug'     => 'haringey-community-benefit-society-hcbs-voids-refurbishment-works',
                'image'    => '/assets/images/2-5-600x600.png',
                'value'    => '£1.4 million',
                'date'     => 'November 2022',
                'status'   => 'Completed',
                'client'   => 'Haringey Community Benefit Society (HCBS)',
                'scope'    => 'Void refurbishment programme for HCBS-managed properties across Haringey, including full internal refurbishments, fabric repairs, kitchen and bathroom replacement, and M&E upgrades across 80 properties.',
                'description' => '<h3>Project Description</h3>
<p>DCK was appointed by the Haringey Community Benefit Society (HCBS) to deliver a void refurbishment programme across its portfolio of residential properties in the London Borough of Haringey. HCBS is a community-owned housing provider and the contract reflected DCK\'s commitment to working with a diverse range of social housing clients across the borough.</p>
<p>The programme covered 80 void properties across various locations within Haringey, each requiring refurbishment to a specified standard before being re-let to HCBS members. Works included full internal redecoration, kitchen and bathroom replacement, floor finish replacement, electrical testing and remediation, heating system servicing and replacement where required, and structural fabric repairs including plastering and joinery.</p>
<p>DCK worked closely with the HCBS management team to agree priorities and manage the programme efficiently. The client\'s community-focused ethos aligned closely with DCK\'s own values, and the project incorporated social value activities including the engagement of local residents in training and employment opportunities associated with the works.</p>
<p>The programme was completed on time and within budget. Post-completion feedback from HCBS highlighted the quality of DCK\'s workmanship, the professionalism of the site teams, and the strong communication maintained throughout the programme as key strengths of the delivery.</p>',
                'gallery'  => [
                    '/assets/images/2-5-600x600.png',
                ],
            ],

            // ── 20 ──────────────────────────────────────────────────────────
            [
                'title'    => 'Hackney Capital Works Programme Refurbishment',
                'category' => 'Construction',
                'slug'     => 'hackney-capital-works-programme-refurbishment',
                'image'    => '/assets/images/1-8-600x600.png',
                'value'    => '£3.6 million',
                'date'     => 'February 2023',
                'status'   => 'Completed',
                'client'   => 'London Borough of Hackney',
                'scope'    => 'Major capital works programme covering external envelope improvements, roofing, window replacement, communal area refurbishments, fire safety upgrades, and planned component replacements across a portfolio of residential blocks in Hackney.',
                'description' => '<h3>Project Description</h3>
<p>DCK was appointed by the London Borough of Hackney to deliver a major capital works programme across its residential housing stock. The programme was procured through a competitive tender process and represented one of the largest single contracts DCK has delivered in the London Borough of Hackney.</p>
<p>External works included re-roofing of multiple blocks using a high-performance flat roofing system, full replacement of windows and external doors across several buildings, external wall painting and cladding repairs, and improvement works to communal external areas including lighting upgrades and landscaping.</p>
<p>Internal communal area works covered full refurbishment of communal corridors, stairwells, and lift lobbies across multiple blocks, including new floor finishes, wall and ceiling treatments, new LED lighting, and improved wayfinding and signage. Lift upgrades were carried out to improve reliability and accessibility for residents.</p>
<p>Fire safety works included fire door replacement throughout all buildings, installation of sprinkler systems in higher-risk blocks, upgrade of fire detection and alarm systems, and improvements to emergency lighting and signage. All fire safety works were designed in consultation with the council\'s Fire Safety team and carried out in compliance with current legislation and the buildings\' fire risk assessments. The programme was completed on programme and within budget, with all properties remaining occupied throughout the works.</p>',
                'gallery'  => [
                    '/assets/images/1-8-600x600.png',
                ],
            ],

        ];

        foreach ($rows as $index => $row) {
            Project::updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'title'       => $row['title'],
                    'category'    => $row['category'],
                    'image'       => $row['image'],
                    'sort_order'  => $index,
                    'value'       => $row['value']       ?? null,
                    'date'        => $row['date']        ?? null,
                    'status'      => $row['status']      ?? null,
                    'client'      => $row['client']      ?? null,
                    'scope'       => $row['scope']       ?? null,
                    'description' => $row['description'] ?? null,
                    'gallery'     => $row['gallery']     ?? null,
                ]
            );
        }
    }
}
