<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubfunctionDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // subfunction_position_id 1 (Strategic Leadership & Vision)
            ['subfunction_position_id' => 1, 'description' => "Set and communicate Megawide's long-term vision and strategic goals."],
            ['subfunction_position_id' => 1, 'description' => "Align all SBUs and corporate units under a unified strategic direction."],
            ['subfunction_position_id' => 1, 'description' => "Regularly review performance against strategic objectives."],
            // subfunction_position_id 2 (Executive Committee & SBU Oversight)
            ['subfunction_position_id' => 2, 'description' => "Govern performance and strategic alignment of all SBUs."],
            ['subfunction_position_id' => 2, 'description' => "Review financial and operational KPIs."],
            ['subfunction_position_id' => 2, 'description' => "Lead the Executive Committee and drive performance across corporate departments."],
            ['subfunction_position_id' => 2, 'description' => "Conduct performance evaluations and provide coaching for Executives."],
            ['subfunction_position_id' => 2, 'description' => "Ensure synergy, collaboration, and cross-functional efficiency across departments and units."],
            // subfunction_position_id 3 (Board & Shareholder Engagement)
            ['subfunction_position_id' => 3, 'description' => "Serve as the key liaison with the Board of Directors and shareholders."],
            ['subfunction_position_id' => 3, 'description' => "Present strategic updates, business plans, and financial results."],
            ['subfunction_position_id' => 3, 'description' => "Oversee regulatory disclosures and shareholder communication."],
            // subfunction_position_id 4 (Organizational Culture & Talent Leadership)
            ['subfunction_position_id' => 4, 'description' => "Champion core values and a high-performance culture."],
            ['subfunction_position_id' => 4, 'description' => "Guide succession planning and talent development."],
            ['subfunction_position_id' => 4, 'description' => "Promote ethical leadership, inclusion, and innovation."],
            // subfunction_position_id 5 (Enterprise Risk Management)
            ['subfunction_position_id' => 5, 'description' => "Oversee the implementation and integration of the enterprise risk management (ERM) framework across all business units."],
            ['subfunction_position_id' => 5, 'description' => "Review top risks, mitigation plans, and ensure alignment with the company’s risk appetite."],
            ['subfunction_position_id' => 5, 'description' => "Uphold corporate governance standards, regulatory compliance, and board-approved policies."],
            ['subfunction_position_id' => 5, 'description' => "Promote a strong risk-aware culture and ethical leadership throughout the organization."],
            // subfunction_position_id 6 (External Representation & Corporate Positioning)
            ['subfunction_position_id' => 6, 'description' => "Represent Megawide in public forums, government engagements, and investor events."],
            ['subfunction_position_id' => 6, 'description' => "Maintain strong relationships with key stakeholders, including partners, regulators, and investors, ensuring transparent and consistent communication"],
            // subfunction_position_id 7 (Process Mapping & Documentation)
            ['subfunction_position_id' => 7, 'description' => "Identify, map, and document key business processes across the organization"],
            ['subfunction_position_id' => 7, 'description' => "Develop standardized process flowcharts, SOPs, and workflow diagrams"],
            ['subfunction_position_id' => 7, 'description' => "Ensure process documentation is accessible, up-to-date, and aligned with organizational standards."],
            // subfunction_position_id 8 (Process Improvement & Optimization)
            ['subfunction_position_id' => 8, 'description' => "Analyze and optimize inefficient processes."],
            ['subfunction_position_id' => 8, 'description' => "Implement automation tools (e.g., robotics process automation) to reduce manual tasks."],
            ['subfunction_position_id' => 8, 'description' => "Measure and report process improvements."],
            // subfunction_position_id 9 (Process Performance Monitoring & Compliance)
            ['subfunction_position_id' => 9, 'description' => "Track process performance using KPIs and dashboards."],
            ['subfunction_position_id' => 9, 'description' => "Ensure processes comply with company policies and regulations."],
            ['subfunction_position_id' => 9, 'description' => "Identify and mitigate process risks."],
            // subfunction_position_id 10 (Process Change Management)
            ['subfunction_position_id' => 10, 'description' => "Coordinate with departments for process changes."],
            ['subfunction_position_id' => 10, 'description' => "Conduct training for new or updated processes to ensure smooth adoption of new workflows."],
            // subfunction_position_id 11 (Security & Access Coordination)
            ['subfunction_position_id' => 11, 'description' => "Develop and enforce security policies, protocols, and procedures for office security."],
            ['subfunction_position_id' => 11, 'description' => "Manage incident response such as but not limited to theft, vandalism, trespassing, and workplace violence."],
            ['subfunction_position_id' => 11, 'description' => "Process gate pass and permit requests for the ingress and egress of people, materials, and equipment."],
            // subfunction_position_id 12 (Housekeeping Supervision)
            ['subfunction_position_id' => 12, 'description' => "Supervise daily cleaning for office, restrooms, pantry, and studio through regular inspections."],
            ['subfunction_position_id' => 12, 'description' => "Ensure waste collection, disposal, and segregation are regularly implemented by conducting regular inspections."],
            ['subfunction_position_id' => 12, 'description' => "Maintain supply levels for cleaning and sanitation products."],
            // subfunction_position_id 13 (Health, Safety, & Emergency Readiness)
            ['subfunction_position_id' => 13, 'description' => "Implement office-level health and safety practices (e.g., fire exits, first aid), and emergency response protocols."],
            ['subfunction_position_id' => 13, 'description' => "Equip employees with emergency response tools and equipment."],
            ['subfunction_position_id' => 13, 'description' => "Conduct regular safety drills and mandatory health and safety trainings to ensure compliance with DOLE and BFP safety regulations."],
            // subfunction_position_id 14 (Facilities Administration)
            ['subfunction_position_id' => 14, 'description' => "Maintain supply levels for pantry (e.g., food, water, disposable utensils) and coffee nook needed for day-to-day use."],
            ['subfunction_position_id' => 14, 'description' => "Prepare and serve meals, snacks, or beverages for internal meetings at 11F CEO office and 11F Boardroom."],
            ['subfunction_position_id' => 14, 'description' => "Manage the scheduling, set-up, and user-friendly access of meeting rooms, pods (10F and 11F), 11F Corporate Boardroom, and studio."],
            ['subfunction_position_id' => 14, 'description' => "Track and ensure timely payment of office utility bills (e.g., landline, water, and electricity) to maintain uninterrupted facility operations."],
            ['subfunction_position_id' => 14, 'description' => "Oversee contract review and renewal with the lessor (RSTP), including sublease to lessee (Citicore)."],
            ['subfunction_position_id' => 14, 'description' => "Track inventory of office fixed assets which includes furniture and fixtures and equipment."],
            ['subfunction_position_id' => 14, 'description' => "Manage parking application and allocation."],
            // subfunction_position_id 15 (Office Maintenance)
            ['subfunction_position_id' => 15, 'description' => "Monitor preventive maintenance and repairs for office equipment  (e.g., aircons - Rockwell Land Corporation, appliances - vendor) including coordinating with respective vendors for repairs and maintenance."],
            ['subfunction_position_id' => 15, 'description' => "Ensure pest control services are administered and monitored in the office periodically through the building administrator for their provided third-party services."],
            ['subfunction_position_id' => 15, 'description' => "Ensure studio equipment (i.e, sound system, intercoms) is properly maintained."],
            // subfunction_position_id 16 (Office Renovation and Upgrades)
            ['subfunction_position_id' => 16, 'description' => "Develop and finalize renovation designs, layouts, and work plans, ensuring alignment with company needs and building guidelines."],
            ['subfunction_position_id' => 16, 'description' => "Monitor construction which covers schedule and budget."],
            ['subfunction_position_id' => 16, 'description' => "Conduct final inspections and manage punch lists of renovated areas."],
            // subfunction_position_id 17 (Facilities Vendor Coordination)
            ['subfunction_position_id' => 17, 'description' => "Source and select qualified vendors for maintenance, housekeeping, security, other facility services, and renovation and upgrade works."],
            ['subfunction_position_id' => 17, 'description' => "Coordinate with vendors to ensure compliance with service agreements and performance standards."],
            ['subfunction_position_id' => 17, 'description' => "Manage vendor contracts, including renewals, performance evaluations, and termination when necessary."],
            // subfunction_position_id 18 (Network & Infrastructure)
            ['subfunction_position_id' => 18, 'description' => "Design, maintain, and optimize network infrastructure across on-premise and cloud environments (e.g., Azure, MS Domain)."],
            ['subfunction_position_id' => 18, 'description' => "Monitor network and server performance and resolve connectivity issues."],
            // subfunction_position_id 19 (Hardware Administration)
            ['subfunction_position_id' => 19, 'description' => "Maintain accurate inventory of IT hardware assets across all locations and users in Corporate Office, including issuance, safekeeping, and storage."],
            // subfunction_position_id 20 (Cybersecurity)
            ['subfunction_position_id' => 20, 'description' => "Network: Install and regularly update firewalls and endpoint protection systems to prevent unauthorized access and malware threats (updated via outsourced Action 1 patching tool)."],
            ['subfunction_position_id' => 20, 'description' => "Software: Install anti-virus and ensure that these are updated based on the latest version (updated via outsourced Action 1 patching tool)."],
            ['subfunction_position_id' => 20, 'description' => "Campaign: Send regular reminders, system notifications to users, and conduct awareness campaigns to prevent phishing, weak passwords, and unsafe digital practices."],
            // subfunction_position_id 22 (Data Management)
            ['subfunction_position_id' => 22, 'description' => "Administer on-premise and cloud-based databases, file servers, and storage systems to ensure data availability and performance."],
            ['subfunction_position_id' => 22, 'description' => "Perform regular system backups, implement disaster recovery procedures, and execute archiving practices."],
            ['subfunction_position_id' => 22, 'description' => "Implement file management systems and standards and conduct periodic compliance audits."],
            // subfunction_position_id 23 (ERP System Administration (SAP))
            ['subfunction_position_id' => 23, 'description' => "Administer and provide technical support to ERP systems (i.e., SAP) ensuring operational continuity and user assistance."],
            // subfunction_position_id 24 (Software Development)
            ['subfunction_position_id' => 24, 'description' => "Develop apps using tools to automate workflows, digitalize processes, and integrate with Microsoft 365 systems."],
            // subfunction_position_id 25 (Networking & Lead Generation)
            ['subfunction_position_id' => 25, 'description' => "Engage in industry events and forums to build stakeholder connections, explore new markets, and identify partners for joint ventures or consortiums."],
            ['subfunction_position_id' => 25, 'description' => "Build and maintain long-term relationships with key stakeholders through regular communication."],
            // subfunction_position_id 26 (New Business Evaluation)
            ['subfunction_position_id' => 26, 'description' => "Conduct preliminary analysis to assess project feasibility, including financial models, valuations, and market research."],
            ['subfunction_position_id' => 26, 'description' => "Prepare and present clear reports on research findings, trends, and recommendations to support strategic decisions."],
            // subfunction_position_id 27 (Bid Management & Proposal Submission)
            ['subfunction_position_id' => 27, 'description' => "Manage the full bid process—coordinate with the client, managing workstreams, gather inputs, and submit a complete and compliant proposal."],
            // subfunction_position_id 28 (Business Plan Preparation & Development)
            ['subfunction_position_id' => 28, 'description' => "Create business plans for new or existing projects, ensuring alignment with strategy and compliance."],
            ['subfunction_position_id' => 28, 'description' => "Coordinate with internal teams and external stakeholders (e.g., Legal, Finance, LGU, government agencies) to secure required documents and approvals to progress the project up to the construction stage."],
            ['subfunction_position_id' => 28, 'description' => "Oversee creation and training of new business units and ensure proper transition."],
            // subfunction_position_id 29 (Business Development Advisory & Consultancy)
            ['subfunction_position_id' => 29, 'description' => "Provide guidance and inputs for general business development initiatives of the business unit, as needed. Participate in regular meetings on key projects."],
            // subfunction_position_id 30 (Government & Industry Relations)
            ['subfunction_position_id' => 30, 'description' => "Monitor and interpret changes in national and local regulations affecting the company and its subsidiaries."],
            ['subfunction_position_id' => 30, 'description' => "Represent the company in engagements with government officials and regulatory agencies."],
            ['subfunction_position_id' => 30, 'description' => "Participate in business councils, chambers, and industry associations."],
            ['subfunction_position_id' => 30, 'description' => "Advocate for favorable business policies through position papers, public consultations, lobbying efforts, or feedback from internal experts."],
            // subfunction_position_id 31 (Stakeholder Engagement)
            ['subfunction_position_id' => 31, 'description' => "Map and manage relationships with key external stakeholders (government agencies and units, NGOs, business groups, civic organizations, among others)."],
            ['subfunction_position_id' => 31, 'description' => "Facilitate stakeholder dialogues or partnerships that align with the company’s long-term goals."],
            // subfunction_position_id 32 (Crisis & Issue Management)
            ['subfunction_position_id' => 32, 'description' => "Manage corporate issues and crises, including crisis communication and business continuity, to mitigate reputational damage or operational disruption."],
            ['subfunction_position_id' => 32, 'description' => "Assist in managing business unit crises to mitigate reputational damage or operational disruption."],
            // subfunction_position_id 33 (Brand Strategy & Identity Oversight)
            ['subfunction_position_id' => 33, 'description' => "Define the master brand narrative, personality, and tone of voice of the company and establish how the parent brand relates to its subsidiaries."],
            ['subfunction_position_id' => 33, 'description' => "Develop and update the visual identity system including logos, typography, iconography, and templates."],
            ['subfunction_position_id' => 33, 'description' => "Ensure consistency in how the brand is presented in digital, print, signage, and environmental applications and approve or guide design elements for campaigns and collateral."],
            // subfunction_position_id 34 (Brand Governance, Compliance, & Integration)
            ['subfunction_position_id' => 34, 'description' => "Provide guidance on how subsidiary brands relate to the corporate brand and offer creative support, when needed."],
            ['subfunction_position_id' => 34, 'description' => "Train internal teams and subsidiaries on correct brand application, review materials for brand compliance, and provide feedback."],
            ['subfunction_position_id' => 34, 'description' => "Conduct brand audits across physical and digital channels."],
            // subfunction_position_id 35 (Multimedia & Creatives Development)
            ['subfunction_position_id' => 35, 'description' => "Conceptualize and produce videos, promotional content, and branded visuals."],
            ['subfunction_position_id' => 35, 'description' => "Support departments in visual storytelling needs for events, reports, and campaigns."],
            // subfunction_position_id 36 (Brand Website, Social Media, & Promotions)
            ['subfunction_position_id' => 36, 'description' => "Design activities and projects that build public awareness and strengthen brand equity."],
            ['subfunction_position_id' => 36, 'description' => "Track perception metrics like brand recall, sentiment, and affinity."],
            ['subfunction_position_id' => 36, 'description' => "Maintain the Company website platform and social media outfits."],
            // subfunction_position_id 37 (Internal Communications)
            ['subfunction_position_id' => 37, 'description' => "Develop employee newsletters and gather employee feedback on communication effectiveness, adjusting strategies accordingly."],
            ['subfunction_position_id' => 37, 'description' => "Assist in the implementation of internal communication needs of corporate departments."],
            // subfunction_position_id 38 (Media & Public Relations)
            ['subfunction_position_id' => 38, 'description' => "Build and maintain a media contact database for proactive and reactive media engagement."],
            ['subfunction_position_id' => 38, 'description' => "Organize press briefings, site tours, or interviews featuring key executives and prepare media kits, press releases, op-eds, and thought leadership articles."],
            // subfunction_position_id 39 (External Communications)
            ['subfunction_position_id' => 39, 'description' => "Align messages with brand and reputation strategy."],
            ['subfunction_position_id' => 39, 'description' => "Assist investor relations on communication materials."],
            ['subfunction_position_id' => 39, 'description' => "Develop creative messaging for company milestones, partnerships, and initiatives."],
            ['subfunction_position_id' => 39, 'description' => "Collaborate with Corporate Branding to ensure alignment in visuals and tone."],
            ['subfunction_position_id' => 39, 'description' => "Develop crisis communication guidelines, drafting holding statements, Q&A documents, and talking points in coordination with Legal."],
            // subfunction_position_id 40 (Executive Support)
            ['subfunction_position_id' => 40, 'description' => "Draft leadership messages for speeches, public statements, or executive interviews."],
            ['subfunction_position_id' => 40, 'description' => "Manage speaking engagements and public appearances of top executives."],
            ['subfunction_position_id' => 40, 'description' => "Prepare leadership communication toolkits for cascading messages to internal teams."],
            // subfunction_position_id 41 (Financial Planning & Analysis)
            ['subfunction_position_id' => 41, 'description' => "Prepare the Parent and Consolidated Annual Operating Plan (AOP) and long-term financial plan."],
            ['subfunction_position_id' => 41, 'description' => "Analyze financial performance and prepare variance analysis against AOP."],
            ['subfunction_position_id' => 41, 'description' => "Support business units with scenario modeling and strategic financial projections."],
            // subfunction_position_id 42 (Corporate Governance, Corporate Secretarial, & Compliance)
            ['subfunction_position_id' => 42, 'description' => "Conduct financial modeling and valuation for investments, acquisitions, and projects."],
            ['subfunction_position_id' => 42, 'description' => "Lead finance transactions on both equity and debt fund raising, and corporate restructuring."],
            ['subfunction_position_id' => 42, 'description' => "Prepare financial analyses for capital structure and capital allocation decisions."],
            ['subfunction_position_id' => 42, 'description' => "Lead financial due diligence and support strategy execution."],
            ['subfunction_position_id' => 42, 'description' => "Manage key stakeholders such as Banks, Credit Agencies, Counsels, Regulators."],
            // subfunction_position_id 43 (Treasury & Cash Management)
            ['subfunction_position_id' => 43, 'description' => "Prepare and consolidate cash flow for AOP and long-term financial plan on both Parent and Consolidated level."],
            ['subfunction_position_id' => 43, 'description' => "Monitor and manage weekly cash flow to maintain liquidity for operational and strategic investments while optimizing return on excess cash thru short term investments."],
            ['subfunction_position_id' => 43, 'description' => "Execute and record treasury transactions covering receipts and disbursements."],
            ['subfunction_position_id' => 43, 'description' => "Administer the debt portfolio, including credit line set-up, timely principal and interest payments, and compliance with all covenant and reporting obligations."],
            ['subfunction_position_id' => 43, 'description' => "Manage banking relationships."],
            ['subfunction_position_id' => 43, 'description' => "Set-up Dividend and Management Fee policy of subsidiaries and monitor compliance."],
            ['subfunction_position_id' => 43, 'description' => "Monitor economic indicators, market trends, and geopolitical events and anticipate and respond to potential impacts on the organization's financial strategy."],
            // subfunction_position_id 44 (Financial & Accounting Operation)
            ['subfunction_position_id' => 44, 'description' => "Set up and implement the Accounting System, including the accounting manual and enterprise resource planning (ERP) software."],
            ['subfunction_position_id' => 44, 'description' => "Process billings to customers (SBUs) and process request for payments."],
            ['subfunction_position_id' => 44, 'description' => "Prepare statutory and management financial reports in compliance with the accounting manual (Parent & Consolidated)."],
            ['subfunction_position_id' => 44, 'description' => "Lead external financial audits, secure approval of audited financial statements (FS) from Audit Committee and comply with statutory filings."],
            // subfunction_position_id 45 (Tax Compliance & Planning)
            ['subfunction_position_id' => 45, 'description' => "Develop and implement tax-efficient strategies for Parent & Subsidiaries."],
            ['subfunction_position_id' => 45, 'description' => "File local and national tax returns in a timely and accurate manner and lead close-out of tax audits."],
            ['subfunction_position_id' => 45, 'description' => "Monitor changes in tax laws and regulatory requirements, evaluate financial impact, and conduct relevant trainings."],
            // subfunction_position_id 46 (Investor Relations)
            ['subfunction_position_id' => 46, 'description' => "Prepare and submit shareholder communications—such as press releases and earnings reports —and file timely and accurate disclosure to the PSE and SEC."],
            ['subfunction_position_id' => 46, 'description' => "Liaise between Megawide and its shareholders, institutional investors, analysts, and credit rating agencies by organizing and managing investor briefings, annual stockholders’ meetings, and other key investor engagements."],
            ['subfunction_position_id' => 46, 'description' => "Monitor investor sentiment and provide strategic insights to Management."],
            ['subfunction_position_id' => 46, 'description' => "Report on the group's Environmental, Social, and Governance (ESG) performance in compliance with global standards such as SASB, TCFD, GRI."],
            // subfunction_position_id 47 (Corporate Governance, Corporate Secretarial, & Compliance)
            ['subfunction_position_id' => 47, 'description' => "Assist in the review of governance structure on all companies, listed or not, of the board and board committees and charters."],
            ['subfunction_position_id' => 47, 'description' => "Manage corporate secretarial work, maintaining and updating corporate records, minutes, and board resolutions, and certifications for all listed and non-listed companies as well as issue Secretary's certificate when needed."],
            ['subfunction_position_id' => 47, 'description' => "Handle incorporation of new companies, manage relevant filings, and oversee corporate housekeeping activities."],
            ['subfunction_position_id' => 47, 'description' => "Comply with the relevant laws and regulations for all companies, as required."],
            ['subfunction_position_id' => 47, 'description' => "Protect and manage trademarks, copyrights, and other intellectual properties."],
            ['subfunction_position_id' => 47, 'description' => "Facilitate processing of select permits and licenses of subsidiaries based on the annual regulatory permits plan."],
            // subfunction_position_id 48 (Contracts Review & Advisory)
            ['subfunction_position_id' => 48, 'description' => "Draft, review, analyze, and negotiate a wide range of contracts and other legal documents for new businesses in Corporate, such as concession agreements, public-private contracts, joint venture agreements, and shareholder agreements, among others."],
            ['subfunction_position_id' => 48, 'description' => "Provide contract advisory services to subsidiaries, as requested, such as review of contracts, claims letter, and other legal correspondences."],
            ['subfunction_position_id' => 48, 'description' => "Establish standard contract templates needed by the subsidiaries for use across the group, including cascading and providing training to them in using these templates."],
            ['subfunction_position_id' => 48, 'description' => "Establish repository system for use across the group, including cascading and providing training to them in using the system."],
            // subfunction_position_id 49 (Litigation)
            ['subfunction_position_id' => 49, 'description' => "Engage and supervise external counsels to perform all litigation, including arbitration and other modes of dispute resolution, and claims. Monitor strategy, case status, costs, and outcomes, coordinating them with the subsidiaries."],
            ['subfunction_position_id' => 49, 'description' => "Oversee employee discipline cases, particularly employee termination cases, for subsidiaries, and provide relevant trainings as requested."],
            ['subfunction_position_id' => 49, 'description' => "Represent the company in legal proceedings, particularly for minor cases, as required."],
            // subfunction_position_id 50 (Mergers, Acquisitions, & Fund Raising Support)
            ['subfunction_position_id' => 50, 'description' => "Provide legal due diligence and transaction support for mergers and acquisitions, joint ventures, or divestments."],
            ['subfunction_position_id' => 50, 'description' => "Ensure compliance with SEC, PSE, PCC, and other relevant regulatory bodies during and after the transactions."],
            ['subfunction_position_id' => 50, 'description' => "Support fund raising activities of MCC and its subsidiaries."],
            // subfunction_position_id 51 (Land Transactions)
            ['subfunction_position_id' => 51, 'description' => "Handle land purchase, transfer of title, and other related services such as land conversion."],
            // subfunction_position_id 52 (Legal Oversight & Audit)
            ['subfunction_position_id' => 52, 'description' => "Provide expert guidance on legal matters as aligned to the strategic direction in regular meetings, including relevant standards, guidelines, tools, and templates, across the group."],
            ['subfunction_position_id' => 52, 'description' => "Monitor legal compliance at the subsidiary level, ensuring contracts are reviewed, enforced, and met agreed standards."],
            // subfunction_position_id 53 (HR Strategy & Organizational Alignment)
            ['subfunction_position_id' => 53, 'description' => "Define and communicate group-wide HR goals aligned with the company’s strategic direction."],
            ['subfunction_position_id' => 53, 'description' => "Facilitate strategic workforce planning across new projects and business units."],
            ['subfunction_position_id' => 53, 'description' => "Ensure organizational design supports business growth, from designing functional and organization structures up to job and competency profiles."],
            // subfunction_position_id 54 (Executive & Key Talent Acquisition)
            ['subfunction_position_id' => 54, 'description' => "Manage and oversee the recruitment of senior management roles across the group and corporate roles."],
            ['subfunction_position_id' => 54, 'description' => "Develop employer branding and recruitment marketing strategies at the group level."],
            // subfunction_position_id 55 (Talent Management & Succession)
            ['subfunction_position_id' => 55, 'description' => "Identify high-potential employees across subsidiaries."],
            ['subfunction_position_id' => 55, 'description' => "Design and manage executive development, coaching, and succession programs."],
            ['subfunction_position_id' => 55, 'description' => "Design and manage career development for non-executives."],
            ['subfunction_position_id' => 55, 'description' => "Support leadership transitions and internal promotions."],
            // subfunction_position_id 56 (Performance Management)
            ['subfunction_position_id' => 56, 'description' => "Set performance standards and guidelines for Corporate and subsidiaries."],
            ['subfunction_position_id' => 56, 'description' => "Implement and monitor a performance management system (PMS) for Corporate and leadership roles by aligning performance metrics with business KPIs."],
            // subfunction_position_id 57 (HR Policy & Compliance)
            ['subfunction_position_id' => 57, 'description' => "Develop and cascade HR policies, which include the code of conduct."],
            ['subfunction_position_id' => 57, 'description' => "Develop HR operating manual for Corporate."],
            ['subfunction_position_id' => 57, 'description' => "Monitor labor law compliance and regulatory adherence (DOLE, SSS, PhilHealth, etc.)."],
            // subfunction_position_id 58 (Learning & Development)
            ['subfunction_position_id' => 58, 'description' => "Evaluate employee development needs to identify skill gaps and growth opportunities."],
            ['subfunction_position_id' => 58, 'description' => "Design targeted learning frameworks covering leadership development (for Corporate and subsidiaries), technical training (for Corporate), and cross-subsidiary capability building."],
            ['subfunction_position_id' => 58, 'description' => "Establish partnerships with training institutions and consultants for enterprise-wide learning initiatives."],
            // subfunction_position_id 59 (Employee Engagement & Culture)
            ['subfunction_position_id' => 59, 'description' => "Conduct periodic employee engagement surveys, which include leadership, job satisfaction, work environment."],
            ['subfunction_position_id' => 59, 'description' => "Lead culture alignment initiatives and group-wide employee engagement programs."],
            ['subfunction_position_id' => 59, 'description' => "Promote a learning culture across the organization."],
            ['subfunction_position_id' => 59, 'description' => "Organize corporate events that reinforce group identity and incorporate Megawide culture."],
            // subfunction_position_id 60 (HR Systems & Analytics)
            ['subfunction_position_id' => 60, 'description' => "Implement and oversee group-wide HR systems (HRIS, payroll tools, etc.)."],
            ['subfunction_position_id' => 60, 'description' => "Maintain secure and organized filing systems (both digital and physical)."],
            ['subfunction_position_id' => 60, 'description' => "Consolidate and analyze HR metrics from subsidiaries (turnover, headcount, cost)."],
            ['subfunction_position_id' => 60, 'description' => "Use data to inform workforce and talent decisions at the group level."],
            // subfunction_position_id 61 (HR Advisory & Compliance Support)
            ['subfunction_position_id' => 61, 'description' => "Provide expert guidance and HR policies, including relevant standards, guidelines, tools, and templates, across the group."],
            ['subfunction_position_id' => 61, 'description' => "Monitor HR compliance and audit readiness at the subsidiary level, ensuring deliverables are within given timeline and meet agreed standards."],
            ['subfunction_position_id' => 61, 'description' => "Facilitate shared learning and best practice exchange among subsidiaries."],
            ['subfunction_position_id' => 61, 'description' => "Provide compliance support, including direction on labor compliance and regulatory adherence and guidance to subsidiaries on whether labor matters should be handled in-house or outsourced."],
            // subfunction_position_id 62 (Admin & Procurement)
            ['subfunction_position_id' => 62, 'description' => "Manage travel arrangements, courier services, vehicle scheduling, and office supplies."],
            ['subfunction_position_id' => 62, 'description' => "Process purchase requisitions, issue purchase orders, coordinate payments, and monitor deliveries and inventories wisely of required goods (office equipment, office supplies, food) of Corporate."],
            // subfunction_position_id 63 (Internal Controls Review)
            ['subfunction_position_id' => 63, 'description' => "Evaluate the efficiency and effectiveness of existing internal controls."],
            ['subfunction_position_id' => 63, 'description' => "Recommend improvements to processes, resource utilization, and internal controls."],
            // subfunction_position_id 64 (Financial Audit & Compliance)
            ['subfunction_position_id' => 64, 'description' => "Verify accuracy and integrity of financial transactions and reports."],
            ['subfunction_position_id' => 64, 'description' => "Assess compliance with financial regulations, company policies, and accounting standards."],
            ['subfunction_position_id' => 64, 'description' => "Evaluate the high risk and fraud areas in financial statements, assess key internal controls, and test transactions and account balances for accuracy and completeness."],
            // subfunction_position_id 65 (IT Audit & Data Governance)
            ['subfunction_position_id' => 65, 'description' => "Audit IT general controls, cybersecurity practices, and data governance."],
            ['subfunction_position_id' => 65, 'description' => "Evaluate system reliability, access controls, and disaster recovery plans."],
            // subfunction_position_id 66 (Whistleblower & Fraud Investigation)
            ['subfunction_position_id' => 66, 'description' => "Investigate whistleblower reports, irregularities, or suspected fraud in collaboration with Legal and Human Resources."],
        ];

        foreach ($data as $item) {
            \App\Models\SubfunctionDescription::create($item);
        }
    }
}
