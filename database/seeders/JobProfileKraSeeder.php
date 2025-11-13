<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class JobProfileKraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Embedded CSV data from the provided file. We'll parse it into an array and insert.
        $csv = <<<'CSV'
id,subfunction_position_id,department,business_unit,kra,kra_description,created_at,updated_at,deleted_at
1,1,OCEO,OCEO,Business Development and Market Growth,Responsible for leading identification of new projects, markets, and private and public partnerships to drive growth and competitiveness.,NULL,NULL,NULL
2,1,OCEO,OCEO,Strategic Leadership and Corporate Direction,Responsible for developing and implementing strategic direction and top-level business goals to strengthen competitiveness, efficiency, and effectiveness in delivering products and services.,NULL,NULL,NULL
3,2,OCEO,OCEO,Business Process Management,Responsible for supporting the President and Chief Executive Officer in developing, managing, reviewing, and improving the business process of the Company and its business units.,NULL,NULL,NULL
4,2,OCEO,OCEO,Business Process Management,Provides support to Management Associates in developing, managing, reviewing, and enhancing business processes for CORP and C2W, and offers improvement inputs and assistance for PH1.,NULL,NULL,NULL
5,2,OCEO,OCEO,Business Strategy Management,Responsible for supporting the President and Chief Executive Officer in managing the business strategy process, including the co-development and monitoring of strategic plans for Corporate and its Business Units.,NULL,NULL,NULL
6,2,OCEO,OCEO,Business Strategy Monitoring & Support,Responsible for assisting the Management Associate in managing the business strategy process, including the co-development and monitoring of strategic plans for the assigned Business Units.,NULL,NULL,NULL
7,2,OCEO,OCEO,Financial Performance,Responsible for maintaining the Company's financial health, ensuring positive cash flow and liquidity.,NULL,NULL,NULL
8,2,Standard,Standard,Governance & SBU Functional Oversight,NULL,NULL,NULL
9,2,OCEO,OCEO,Governance Structure & Reporting,Responsible for developing and implementing strategic direction and top-level business goals to strengthen competitiveness, efficiency, and effectiveness in delivering products and services.,NULL,NULL,NULL
10,2,OCEO,OCEO,Governance Support,Responsible for assisting the Management Associate in meetings led by the President and Chief Executive Officer through schedule coordination, agenda distribution, minute drafting, and assisting in reviewing and preparing PH1, C2W, and PCS reports.,NULL,NULL,NULL
11,2,OCEO,OCEO,Operational Oversight and Performance Management,Responsible for overseeing Company operations with a strong focus on operational excellence, ensuring accountability and efficiency in delivering high-quality projects.,NULL,NULL,NULL
12,4,Standard,Standard,Building the Culture & Employee Engagement,NULL,NULL,NULL
13,4,Standard,Standard,Building, Leading, & Evaluating Executive Leaders,NULL,NULL,NULL
14,4,Standard,Standard,Managing a High-Performing Team,Responsible for developing a high performing and engaged team by diligently mentoring and coaching team members to enhance their competencies and create a conducive climate where they are engaged to perform their best and contribute to the attainment of team objectives.,NULL,NULL,NULL
15,4,OCEO,OCEO,Organizational Leadership and Talent Development,Responsible for ensuring the senior management team is highly competent and actively leads their teams to achieve business unit goals and targets and fostering a culture of organizational excellence and high-performing teams, anchored on Company vision, mission, and values.,NULL,NULL,NULL
16,5,BDV,BDV,Business Case Development,Responsible for overseeing the project development cycle, from business case preparation to recommendation, to determine the viability of a project.,NULL,NULL,NULL
17,5,OCEO,OCEO,Enterprise Risk Management,Responsible for supporting the President and Chief Executive Officer in managing the ERM process, co-developing and reviewing the Company and its Business Units’ (CORP, EPC, PCS, PH1, PTX, C2W) ERM program, and preparing and reporting quarterly updates to the Board Risk Oversight Committee (BROC).,NULL,NULL,NULL
18,5,OCEO,OCEO,Enterprise Risk Management,Responsible for providing assistance to Management Associates in co-developing and reviewing the enterprise risk management program of CORP, EPC, PCS, PH1, PTX, and C2W in preparing quarterly updates for the Board Risk Oversight Committee (BROC).,NULL,NULL,NULL
19,5,BDV,BDV,Financial Modelling,NULL,NULL,NULL
20,5,OCEO,OCEO,Governance, Risk, and Compliance,Responsible for overseeing Company operations with a strong focus on governance, compliance, and ethical practices, ensuring transparency in all activities.,NULL,NULL,NULL
21,5,BDV,BDV,Portfolio Expansion,Responsible for supporting the Chief Business Development Officer in leading the team in creating avenues to expand or replicate its infrastructure portfolio.,NULL,NULL,NULL
22,5,Standard,Standard,Risk Management,NULL,NULL,NULL
23,6,OCEO,OCEO,Corporate Communication and Representation,Responsible for building and sustaining strong stakeholder relationships as the Company’s prime representative, ensuring transparency and trust to support long-term sustainability, reputation, and value creation.,NULL,NULL,NULL
24,11,OCEO,FACM,Security Management,Responsible for overseeing and ensuring a safe working environment by implementing effective security measures to protect employees, guests, and assets.,NULL,NULL,NULL
25,12,OCEO,FACM,Housekeeping Management,Responsible for the cleanliness and effectiveness of the corporate office environment, managing outsourced personnel in carrying out work plans and initiatives in relation to housekeeping, waste management, and pest control, among others.,NULL,NULL,NULL
26,13,OCEO,FACM,Health & Safety,Responsible for creating and sustaining a safe and healthy workplace for employees, guests, and visitors by setting policies and frameworks, reducing hazards, promoting well-being, and ensuring compliance with health and safety regulations and ethical standards.,NULL,NULL,NULL
27,14,OCEO,FACM,Office Administration,Responsible for overseeing the house rules for the use of Office Facilities (floor, walls, doors, among others), Office Equipment (aircon,  kitchen, lightings, among others), Studio and Board Room Equipment, Appliances (coffee machine, among others), and Furniture and for the timely and accurate payment of utilities (power and water), monitoring their optimum usage by checking and tracking efficiency.,NULL,NULL,NULL
28,15,OCEO,FACM,Office Equipment Maintenance,Responsible for overseeing the house rules for the maintenance of Office Facilities (floor, walls, doors, among others), Office Equipment (aircon,  kitchen, lightings, among others), Studio Equipment, Appliances (coffee machine, among others), and Furniture, including regular scheduled preventive maintenance and corrective procedures.,NULL,NULL,NULL
29,16,OCEO,FACM,New Office Equipment & Renovation,Ensures the successful planning, execution, and completion of facility-related projects by coordinating resources, managing budgets, and adhering to timelines, while maintaining a safe and efficient environment that meets the needs of all stakeholders.,NULL,NULL,NULL
30,18,OCEO,ITD,Network & Infrastructure,NULL,NULL,NULL
31,19,OCEO,ITD,Hardware Administration,NULL,NULL,NULL
32,20,OCEO,ITD,Cybersecurity,NULL,NULL,NULL
33,21,OCEO,ITD,Software Development,NULL,NULL,NULL
34,22,OCEO,ITD,Data Management,NULL,NULL,NULL
35,24,OCEO,ITD,Software Administration,NULL,NULL,NULL
36,25,BDV,BDV,Identification & Opportunity Management ,Responsible for supporting the Business Development Manager and Director in searching for potential opportunities aligned with the company's strategic plan or five-year roadmap.,NULL,NULL,NULL
37,25,BDV,BDV,Networking & Stakeholder Management,Responsible for fostering positive relationships with stakeholders to support organizational goals.,NULL,NULL,NULL
38,25,BDV,BDV,Networking & Stakeholder Management,Responsible for fostering positive relationships with stakeholders, ensuring their satisfaction and engagement, and building a network to support organizational goals.,NULL,NULL,NULL
39,25,BDV,BDV,Stakeholder Management,Responsible for updating and accomplishing the stakeholder map and engagement plan and ensuring upload to the digital stakeholder management register.,NULL,NULL,NULL
40,30,CAB,CAB,Corporate Affairs Support,Responsible in supporting activities to enhance and maintain relationships with corporate stakeholders, providing administrative assistance and database management support.,NULL,NULL,NULL
41,39,CAB,CAB,Corporate Communications,Responsible for creating strategic communication materials for internal and external audiences and developing and maintaining effective relationship with  the media for the advancement of Company interests.,NULL,NULL,NULL
42,41,FIN,CMP,Annual Operating Plan Consolidation,Responsible in consolidating the AOP of Parent and Consolidated, validating the assumptions used by the business units in their AOP to ensure alignment with their approved strategic initiatives.,NULL,NULL,NULL
43,41,FIN,CFP,Financial Business Partnering,Responsible for providing on-time and quality professional advice and services to business unit heads across the Company and its group.,NULL,NULL,NULL
44,41,FIN,CFP,Financial Modeling & Forecasting,Responsible for preparing financial models that represent a business or project’s current and future financial performance (5 year and 7 year forecasting), assess investment opportunities (capital market evaluation) and calculate the financial impact of decisions or future events.,NULL,NULL,NULL
45,41,FIN,CFP,Financial Planning,Responsible for managing the preparations of the five-year and seven-year financial projections to ensure alignment with the overall direction of the Chief Finance Officer.,NULL,NULL,NULL
46,41,FIN,FIN,Financial Planning & Strategy,Responsible for providing strong strategic business partnership with the President and Chief Executive Officer, conducting periodic assessment of the Company's financial performance and long-term strategic plan.,NULL,NULL,NULL
47,41,FIN,CFP,Management Reporting,Responsible for preparing and analyzing the financial report of the Company and its group to assist the management in its business decisions.,NULL,NULL,NULL
48,41,FIN,TRE,Market Outlook,Responsible for ensuring that the Company is updated on market outlook and economic indicators to anticipate and prepare for potential impacts on the company’s cash flow, risk exposure, and investment returns.,NULL,NULL,NULL
49,42,FIN,CFP,Fund Raising,Responsible for the assessment, structuring, negotiation, and execution of capital-raising initiatives, such as project financing and mergers and acquisitions (M&A).,NULL,NULL,NULL
50,42,FIN,CMP,Fund Raising Support,Responsible for supporting the Head of Corporate Finance and Planning in raising financial capital needed to maintain Company's cash flow in completing relevant projects.,NULL,NULL,NULL
51,42,FIN,CFP,Investment Evaluation,Responsible for finance-related support for reporting reasonable base case internal rate of return, payback period, and net present value, presenting best and worst cases to the Management Investment Committee (MIC).,NULL,NULL,NULL
52,42,FIN,CFP,Investment Evaluation & Portfolio Management,Responsible for providing financial and strategic assessment of Business Development’s priority projects and aligning the Group’s investment portfolio and debt headroom capacity.,NULL,NULL,NULL
53,42,FIN,TRE,Investment Management,Responsible for maximizing return on excess cash by investing the surplus in accordance with the agreed parameters on the investment policy.,NULL,NULL,NULL
54,43,FIN,TRE,Bank Account Management,Responsible for maintaining a healthy business relationship with banks and providing reciprocal business to all lenders.,NULL,NULL,NULL
55,43,FIN,TRE,Cash & Liability Management,Responsible for effectively managing cash positions to support operational needs and strategic objectives, monitoring daily cash flows, forecasting future cash requirements, implementing strategies to maintain optimal cash reserves, and reconciling bank statements.,NULL,NULL,NULL
56,43,FIN,CFP,Liability Management,Responsible for reviewing the accuracy of financial data of the Company and its business units.,NULL,NULL,NULL
57,43,FIN,FIN,Treasury,Responsible for the overall direction and oversight of cash flow planning, ensuring availability of short, medium and long-term funding requirements of the Company and its group.,NULL,NULL,NULL
58,43,FIN,TRE,Treasury Operations,Responsible for ensuring the smooth flow of day-to-day operations of the team and leveraging technology and automation to improve efficiency and accuracy in treasury operations.,NULL,NULL,NULL
59,43,FIN,TRE,Treasury Systems Management,Responsible for accurate and efficient financial reporting and analysis by capturing, processing, and integrating all financial transactions in the system.,NULL,NULL,NULL
60,43,FIN,TRE,Working Capital Management,Responsible for reviewing and analyzing related party receivables, payables, and the debt and equity requirements of the company and its subsidiaries, considering future working capital needs.,NULL,NULL,NULL
61,44,FIN,CMP,Accounting Operations & Budget Management,Responsible in oversees Corporate Office and Foundation accounting activities such as but not limited to billing, payment, payroll, budget management and reporting.,NULL,NULL,NULL
62,44,FIN,CMP,Accounts Payable,Responsible in processing and reviewing corporate and foundation disbursements, in accordance with the transactions approved by their respective department or unit heads, as applicable.,NULL,NULL,NULL
63,44,FIN,CMP,Billing Management,Responsible in the preparation and sending of billings to business units and ensuring the recording of billings in the Enterprise Resource Planning software.,NULL,NULL,NULL
64,44,FIN,CMP,ERP Database Administration,Responsible for approving requests for addition and deletion of General Ledger (GL) accounts, vendor data, and customer master data of the Enterprise Resource Planning (ERP) database of the Company and its subsidiaries.,NULL,NULL,NULL
65,44,FIN,CMP,Financial Reporting,Responsible for leading the preparation of monthly, quarterly, and annual Parent and Consolidated financial reports, both management and statutory, and presenting these reports to the Corporate Finance Committee, Audit Committee, and the Chief Executive Officer.,NULL,NULL,NULL
66,44,FIN,FIN,Financial Reporting & Compliance,Responsible for overseeing and supporting the preparation of financial and management reports by ensuring the accurate and timely availability of financial information to support management financial decisions.,NULL,NULL,NULL
67,44,FIN,CMP,Financial Statements Preparation,Responsible for providing support in the preparation of financial statements and other mandatory reports.,NULL,NULL,NULL
68,44,FIN,CMP,Statutory Financial Reporting,Responsible for the preparation of financial statements, in accordance with the accounting standards, and other mandatory reports quarterly and annually in compliance with the requirements of all regulatory agencies and to convey the financial performance of the Company to its stakeholders.,NULL,NULL,NULL
69,45,FIN,CMP,Tax Compliance & Tax Audit Management,Responsible for consolidating, filling and processing payments of taxes due for the Company and other business units to the Bureau of Internal Revenue (BIR).,NULL,NULL,NULL
70,45,FIN,CMP,Tax Compliance Assistance,Prepares and files tax returns for the Company and its operating and non-operating subsidiaries, which includes but not limited to withholding taxes, value-added taxes (VAT), and income tax, pay on or before due date.,NULL,NULL,NULL
71,45,FIN,CMP,Tax Compliance Review,Responsible for the review, evaluation and monitoring of the compliance of SBUs with the existing tax rules and regulations, identify possible tax exposures and recommend action plans to mitigate the risks.,NULL,NULL,NULL
72,45,FIN,CMP,Tax Incentives Availment,Responsible that available tax incentives are optimized and regular requirements of regulators are complied with,NULL,NULL,NULL
73,45,FIN,CMP,Tax Planning,Responsible for preparing the annual tax planning, covering value added tax (VAT) and income tax of the Company.,NULL,NULL,NULL
74,45,FIN,CMP,Tax Planning & Compliance,Responsible for preparing the Company's tax planning, which includes income tax and value-added tax (VAT), filing returns accurately and timely, and ensuring the required business permits and licenses are secured to avoid back taxes and penalties.,NULL,NULL,NULL
75,45,FIN,CMP,Tax Updates & Information Dissemenation,Reponsible for gathering relevant tax updates and ensuring  that the business units are aware of these to ensure proper execution.,NULL,NULL,NULL
76,46,FIN,IRO,Annual Sustainability Reporting,Responsible for ensuring that the annual sustainability report is comprehensive, accurate, and aligns with best practices and regulatory requirements.,NULL,NULL,NULL
77,46,FIN,CMP,Investor Engagement & Relationship Management,Responsible for building and sustaining strong, positive relationships with investors, analysts, and other key stakeholders by providing analyst coverage and managing relationships with investors and stakeholders.,NULL,NULL,NULL
78,46,FIN,FIN,Investor Relations,Responsible for developing and managing relationship with financial partners.,NULL,NULL,NULL
79,46,FIN,IRO,Investor Relations Programs,Responsible for assisting and ensuring the  transparency, consistency, and effective communication with investors and helping to build confidence and support for the company's long-term success.,NULL,NULL,NULL
80,46,FIN,CMP,Investor Relations Strategy & Brand Equity,Responsible for supporting activities to successfully raise financial capital needed to pay for projects through debt or equity financing for approved projects by the Management Investment Committee.,NULL,NULL,NULL
81,46,FIN,IRO,Stakeholder Communications,Responsible for establishing and maintaining channels for stakeholders and analyzing feedback and raise inquiries.,NULL,NULL,NULL
82,47,LEG,LEG,Corporate Compliance,Responsible for regulatory compliance in order to manage regulatory risks.,NULL,NULL,NULL
83,47,LEG,LEG,Corporate Governance,Responsible for overseeing, monitoring, and managing the corporate secretarial team in the preparation and implementation of policies and procedures pertaining to corporate governance, as required by applicable laws and best practices, to ensure that the Company and its group is governed pursuant to the highest level of integrity, transparency, and good governance.,NULL,NULL,NULL
84,47,LEG,LEG,Corporate Secretarial & Compliance,Responsible for overseeing corporate secretarial services and for the periodic review of governance structure, manual, policies, and processes and for recommending to the Board revisions thereof.,NULL,NULL,NULL
85,47,LEG,LEG,Corporate Secretarial & Corporate Compliance Support,Responsible for assisting in the preparation and maintenance of corporate secretarial and governance documents.,NULL,NULL,NULL
86,47,LEG,LEG,Corporate Secretarial Management,Responsible for overseeing, monitoring, and managing the corporate secretarial team in arranging Board, Board Committee, and stockholders' meetings, as well as completing all deliverables related to corporate secretarial duties for the Company and its group.,NULL,NULL,NULL
87,47,LEG,LEG,Regulatory Data Management,Responsible for consolidating documents, reports, and information relating to the regulatory requirements of the Company, its subsidiaries, and its operating units to build and maintain a central repository.,NULL,NULL,NULL
88,47,LEG,LEG,Regulatory Requirements Management,Responsible in ensuring all regulatory requirements needed by the Company, its subsidiaries, and operating units are updated and timely complied with, securing compliance and mitigating potential risks.,NULL,NULL,NULL
89,48,LEG,LEG,Claims & Contract Management,Responsible for drafting, reviewing, revising, and monitoring simple contracts and agreements entered into by the Company and for handling and monitoring small claims involving the Company, ensuring proper documentation and minimizing legal risks for the Company.,NULL,NULL,NULL
90,48,LEG,LEG,Contract Administration & Management,Responsible for drafting, reviewing, revising, monitoring, and assisting in the negotiation of contracts entered into by the Company to respond with stakeholder needs.,NULL,NULL,NULL
91,48,LEG,LEG,Contracts & Special Projects,Responsible for developing the contracts processing framework; Responsible for overseeing the contracts processing procedure, contracts management, special projects and transactions (i.e., Joint Venture Agreements, Mergers and Acquisitions, Land Acquisitions, Shareholders Agreement, and similar agreements), and due diligence for all business units.,NULL,NULL,NULL
92,48,LEG,LEG,Legal Advisory & Assistance,Responsible for providing legal advice, opinions, and other necessary legal assistance for all transactions of the Company and its stakeholders.,NULL,NULL,NULL
93,48,LEG,LEG,Legal Stakeholder Management,Responsible for ensuring the timely submission of documents required by the team and creating a good and healthy working relationship with government agencies for the best interest of the Company.,NULL,NULL,NULL
94,49,LEG,LEG,Claims & Litigation Management,Responsible for handling and monitoring claims and cases involving the Company and coordinating with external counsel if the Company decides to engage them.,NULL,NULL,NULL
95,49,LEG,LEG,Litigation,Responsible for overseeing the effective and professional management of litigation cases to ensure that reputational and business risk are minimized.,NULL,NULL,NULL
96,50,LEG,LEG,Legal Research & Due Diligence,Responsible for undertaking comprehensive legal research on a wide range of subjects relative to the cases, claims, and contracts handled by the Legal Counsel and assisting the Corporate Regulatory Officer in performing land due diligence and land transfer.,NULL,NULL,NULL
97,50,LEG,LEG,Special Project Support ,Responsible for providing support for the Company's Special Projects, including but not limited to business development and expansion and specific business unit projects requiring legal support.,NULL,NULL,NULL
98,51,LEG,LEG,Land Transactions Oversight,- ,NULL,NULL,NULL
99,51,LEG,LEG,Management of Land Transactions,Responsible for managing land conversion and title transfer transactions, ensuring all land-related legal processes are handled efficiently and in compliance with relevant laws and regulations.,NULL,NULL,NULL
100,52,LEG,LEG,Legal Archives & Document Control,Responsible for maintaining and documenting contract templates, case files, and other legal documents.,NULL,NULL,NULL
101,52,LEG,LEG,Legal Services Support,Responsible for providing full support to Legal Services in the accurate and timely preparation, draft, review, filing, and maintenance of contracts, claims, litigation, and other legal documents, while ensuring efficient and effective communication between team members and external stakeholders.,NULL,NULL,NULL
102,53,HRD,HRD,Executive Leaning and Capability Development,Responsible for developing and implementing a learning and capability development strategy and roadmap for executives across corporate and business units.,NULL,NULL,NULL
103,53,HRD,OD,Job & Competency Profiling,Responsible for regularly updating, maintaining, and cascading the job and competency profiles, following the organizational reviews.,NULL,NULL,NULL
104,53,HRD,HRD,Organization Development,Responsible for overseeing organization development initiatives across corporate and business units as aligned with overall corporate strategy.,NULL,NULL,NULL
105,53,HRD,OD,Organizational Design,Responsible for developing and cascading the organizational structure and competency profiling learning materials and templates and providing advice and support on organizational plans and reviews involving organization and job design for corporate departments.,NULL,NULL,NULL
106,53,HRD,OD,Performance Management,Responsible for designing, implementing, monitoring, and evaluating the performance management system (PMS) for corporate, ensuring its effectivity in building a high-performing orgnanization, while also providing guidance to all business units in aligning their own performance management process.,NULL,NULL,NULL
107,54,HRD,TA/OPS,Employer Branding & Strategic Sourcing,Responsible for developing, implementing, and monitoring the effectiveness of talent attraction activities, creating employee value proposition with Corporate Communciations, Corporate Affairs, and Branding to market the Company to potential candidates and managing and tracking the different recruitment channels.,NULL,NULL,NULL
108,54,HRD,HRD,Executive Talent Acquisition & Management,Responsible for developing and implementing the executive talent acquisition and management strategy to attract, retain, and develop leaders who embody the Company’s values, drive business goals, and ensure a strong leadership pipeline for long-term sustainability.,NULL,NULL,NULL
109,54,HRD,TA/OPS,Recruitment Planning & Design,Responsible for developing and implementing strategic talent acquisition initiatives and policies, including manpower planning, to proactively build and maintain a quality talent pipeline and fill open positions within the service-level agreement (SLA) and budget.,NULL,NULL,NULL
110,54,HRD,TA/OPS,Sourcing & Recruitment Operations,NULL,NULL,NULL
111,55,HRD,HRD,Culture Transformation,Responsible for facilitating and implementing culture development initiatives across corporate and business units to strengthen culture and embed core values, as aligned Company’s mission, vision, and goals.,NULL,NULL,NULL
112,55,HRD,TMTR,Development & Succession Planning,NULL,NULL,NULL
113,55,HRD,OD,Executive & Key Talent Management,Responsible for designing and implementing programs to manage executives and key talents, identifying, developing, retaining and deploying employees with high potential to ensure that their development solutions are effectively facilitated and to prepare them for critical and leadership roles.,NULL,NULL,NULL
114,55,HRD,LE,Learning Administration & Evaluation,Responsible for creating a structured, efficient, and effective learning environment supporting organizational goals and employee development.,NULL,NULL,NULL
115,55,HRD,LE,Learning Management System,Responsible for assisting in the setting up and updating of the LMS which will host behavioral, leadership, management, and technical courses, enabling employees to have wide options in learning at their own pace.,NULL,NULL,NULL
116,55,HRD,LE,Needs Analysis & Curriculum Design,Responsible in assisting in the creation of a learning curriculum to enhance employee skills, improve job performance, and align learning outcomes with organizational objectives, ensuring employees are continuously developed to meet both current and future business needs.,NULL,NULL,NULL
117,55,HRD,TMTR,Talent Assessment,NULL,NULL,NULL
118,55,HRD,LE,Talent Management Support,Responsible in implementing and monitoring talent management and development for executives and facilitating its execution across business units, ensuring appropriate and applicable learning intervention is available based on their development plans.,NULL,NULL,NULL
119,57,HRD,TA/OPS,Benefits Administration,Responsible for administering and managing the Company's employee benefits programs, ensuring compliance to organizational policies and local regulations.,NULL,NULL,NULL
120,57,HRD,TMTR,Benefits Strategy Formulation & Management,Responsible for designing and managing employee benefits programs, including health and wellness, retirement plans, and other benefits.,NULL,NULL,NULL
121,57,HRD,TMTR,Compensation Strategy & Management,Responsible for developing and executing a comprehensive total rewards philosophy and strategy that aligns with the organization’s goals, culture, and values.,NULL,NULL,NULL
122,57,HRD,HRIS,Continuous Improvement & Employee Support,Responsible for continuously improving HRIS processes and functionalities and  for providing effective training and support to users, resulting to user satisfaction and competence.,NULL,NULL,NULL
123,57,HRD,TA/OPS,Employee Data Management,Responsible for the overall governance, integrity, and management of employee data within the Human Resources Information System (HRIS) and physical 201 records, ensuring compliance with data protection regulations and supporting HR Operations through accurate data reporting and analysis.,NULL,NULL,NULL
124,57,HRD,TA/OPS,Executive Benefits Administration,NULL,NULL,NULL
125,57,HRD,HRD,Executive Payroll, Compensation, and Benefits,Responsible for the execution of benefits for executives across the Company,NULL,NULL,NULL
126,57,HRD,TA/OPS,Exptriates Management,NULL,NULL,NULL
127,57,HRD,TA/OPS,Government Compliance & Reporting,Responsible for submitting scheduled government forms and reports in compliance to labor and other regulatory requirements.,NULL,NULL,NULL
128,57,HRD,TA/OPS,HR Compliance & Labor Management,Responsible for managing the overall compliance with local labor laws and regulations across all human resources functions, while maintaining a positive work environment.,NULL,NULL,NULL
129,57,HRD,TA/OPS,HR Information Systems,Responsible for ensuring the maintenance and regular updates of the HRIS, including data integrity, completion, and security.,NULL,NULL,NULL
130,57,HRD,TA/OPS,HR Policy Development,NULL,NULL,NULL
131,57,HRD,TA/OPS,HR Records Administration,NULL,NULL,NULL
132,57,HRD,HRIS,HRIS Management & Implementation,Responsible for maintaining high operational standards and user satisfaction with the HRIS, ensuring smooth operations of the current platform and successfully deploying system changes with minimal disruption to HR Operations.,NULL,NULL,NULL
133,57,HRD,TA/OPS,Payroll & Benefits Administration,Responsible for managing and overseeing the payroll processes and benefits programs of corporate and executive employees, as well as for other assigned business units, ensuring they are paid accurately and on time and that benefits are administered effectively and in compliance with legal requirements.,NULL,NULL,NULL
134,57,HRD,TA/OPS,Payroll Management,Responsible for overseeing payroll operations, ensuring accuracy and compliance with all regulatory requirements and implementing it with efficiency.,NULL,NULL,NULL
135,57,HRD,HRD,Performance and Strategic Rewards,Responsible for developing and implementing a performance management system and a total rewards strategy for corporate and executives as aligned with corporate strategy.,NULL,NULL,NULL
136,57,HRD,TA/OPS,Rewards & Recognition Implementation,NULL,NULL,NULL
137,57,HRD,TA/OPS,Vendor and Systems Management,Responsible in facilitating and maintaining relationships between the organization and vendors and partners, negotiating contracts, creating standards for the vendors, and finding the best available vendors.,NULL,NULL,NULL
138,57,HRD,HRIS,Vendor Management,Responsible for maintaining productive relationships with HRIS vendors and managing HRIS project deliverables effectively.,NULL,NULL,NULL
139,59,HRD,OD,Culture Building & Change Management,Responsible for conducting organization diagnosis and employee engagement surveys in all business units to determine the gaps and priority areas and recommend relevant interventions in improving workforce engagement.,NULL,NULL,NULL
140,59,HRD,LE,Employee Engagement,NULL,NULL,NULL
141,62,HRD,ADM/PUR,Asset Management Coordination,Responsible for coordinating administrative functions, including  telecommunications and purchase and maintenance of shuttle vehicles and office supplies.,NULL,NULL,NULL
142,62,HRD,ADM/PUR,Document Delivery & Pick Up,Responsible for delivering messages, documents, packages, and other items between offices or departments within the organization or to external business partners, ensuring all necessary documentation is completed after each delivery.,NULL,NULL,NULL
143,62,HRD,ADM/PUR,Executive Support,Responsible for providing comprehensive administrative support to the Chief Human Resources Officer, which includes organizing the schedule of and assisting the Chief Human Resources Officer to maximize executive time for all matters; providing a wide range of general services and administrative support in the achievement of the Chief Human Resources Officer's objectives, and; supporting the department head in ensuring the stability and alignment of the team to achieve organizational success.,NULL,NULL,NULL
144,62,HRD,ADM/PUR,Executive Vehicle Benefit Management,Responsible for determining when and what kind of maintenance the vehicle needs, keeping track of general maintenance schedules and motor condition.,NULL,NULL,NULL
145,62,HRD,ADM/PUR,Executive Vehicle Benefit Plan,Responsible for coordinating administrative functions in relation to executive vehicle benefit, including  processing of request for repairs and maintenance, claims, insurance, registration and renewal of benefit.,NULL,NULL,NULL
146,62,HRD,ADM/PUR,Office Administrative Services,Responsible for ensuring seamless coordination and effective communication with both internal teams and external service providers to facilitate travel bookings, manage messengerial services, and coordinate shuttle services efficiently.,NULL,NULL,NULL
147,62,HRD,ADM/PUR,Purchasing Administrative Services,Responsible for supporting all purchasing activities in accordance with established policies and procedures, ensuring purchasing documentation is accurate and up-to-date.,NULL,NULL,NULL
148,62,HRD,ADM/PUR,Service Vehicle Maintenance,Responsible for determining when and what kind of maintenance the vehicle needs, keeping track of general maintenance schedules and car condition.,NULL,NULL,NULL
149,62,HRD,ADM/PUR,Transport of Persons, Goods, & Documents,Responsible for safely transporting company employees, as well as various products and materials, to and from specified locations in a timely manner.,NULL,NULL,NULL
150,63,OCHR,IAD,Controls Evaluation,Responsible for assessing effectiveness of internal controls and recommending enhancements to reduce exposures and prevent losses or inefficiencies.,NULL,NULL,NULL
151,63,OCHR,IAD,Operational Efficiency,NULL,NULL,NULL
152,63,OCHR,IAD,Operational Process Audits,Responsible in performing operational audits, from operations process up to reporting, for Megawide subsidiaries and affiliates.,NULL,NULL,NULL
153,64,OCHR,IAD,Audit Compliance,Responsible for checking adherence to internal audit standards, regulatory requirements, and audit recommendations.,NULL,NULL,NULL
154,64,OCHR,IAD,Audit Reporting,Responsible for providing the Board of Directors, the Audit Committee, and senior management with timely, accurate, and independent reports on audit findings, risk exposures, and control issues to support strategic decision-making and effective governance.,NULL,NULL,NULL
155,64,OCHR,IAD,Audit Reporting,Responsible for preparing and communicating audit results and monitoring the implementation of corrective actions to ensure resolution of audit issues.,NULL,NULL,NULL
156,64,OCHR,IAD,Financial Process Audits,Responsible for conducting financial audits to ensure the accuracy, completeness, and integrity of financial reporting for assigned subsidiaries and affiliates in line with the approved Internal Audit Plan.,NULL,NULL,NULL
157,64,OCHR,IAD,Risk Assessment and Response,Responsible for independently assessing the effectiveness of the organization’s risk identification, mitigation, and control processes under the Megwaide Enterprise Risk Management (ERM) framework.,NULL,NULL,NULL
158,65,OCHR,IAD,Operational Efficiency,Responsible for enhancing the efficiency and effectiveness of internal processes through audit insights, risk identification, and continuous improvement initiatives.,NULL,NULL,NULL
159,65,OCHR,IAD,System Controls & Information Security Audits,Responsible for conducting Information technology (IT) audits covering Enterprise Resource Planning (ERP) systems, IT general controls, cybersecurity, and data privacy for Megawide subsidiaries and affiliates.,NULL,NULL,NULL
160,67,CAB,CAB,Corporate Branding,Responsible for managing the Company's brand and reputation, maintaining and cascading brand identity and guidelines and supporting internal and external branding and event requirements for corporate and other business units.,NULL,NULL,NULL
161,75,BDV,BDV,Development of Value-Enhancing Initiatives,Responsible for supporting the Chief Business Development Officer in leading the team in identifying and reviewing business cases for value-enhancing initiatives or opportunities for business units.,NULL,NULL,NULL
162,76,CAB,CAB,Crisis Management,Responsible in supporting the mitigation, management, and resolution of the issues and crises that threaten the reputation of the Company and its group based on the approved policie and guidelines.,NULL,NULL,NULL
163,NULL,FIN,IRO,Brand Equity & Coporate Identity Management,Responsible for  providing assistance to strengthen the brand equity and corporate identity by aligning the Company's branding and messaging to the programs initiated by internal units, ensuring effective communication to external stakeholders and providing manpower support when necessary.,NULL,NULL,NULL
164,NULL,CAB,CAB,Corporate Affairs,NULL,NULL,NULL
165,NULL,FIN,FIN,Corporate Finance,NULL,NULL,NULL
166,NULL,OCHR,IAD,Enterprise Risk Management Support,Responsible in supporting the team in evaluating and enhancing the effectiveness of Megawide Enterprise Risk Management (ERM) Program and Framework.,NULL,NULL,NULL
167,NULL,LEG,LEG,Executive Support,NULL,NULL,NULL
168,NULL,OCEO,OCEO,Meeting Management,Responsible for organizing the schedule of and assisting the President and Chief Executive Officer to maximize executive time for all matters.,NULL,NULL,NULL
169,NULL,BDV,BDV,Meeting Management,Responsible for assisting in the organizing the schedule of the Chief Business Development Officer to maximize executive time.,NULL,NULL,NULL
170,NULL,CAB,CAB,Meeting Management,Responsible for organizing  the schedule of and assisting the Vice Chairman to maximize executive time for all matters.,NULL,NULL,NULL
171,NULL,FIN,FIN,Meeting Management,Responsible for organizing the schedule of and assisting the Chief Finance Officer to maximize executive time for all matters.,NULL,NULL,NULL
172,NULL,BDV,BDV,New Business Generation,Responsible for supporting the Chief Business Development Officer in: (a) leading the team, and; (b) contributing to the Company's growth trajectory by finding new businesses and opportunities that effectively expand the Company's revenue sources, thus leading to long-term growth.,NULL,NULL,NULL
173,NULL,OCEO,OCEO,Office Administration (Dept),Responsible for supporting the President and Chief Executive Officer in ensuring the stability and alignment of the unit to achieve organizational success.,NULL,NULL,NULL
174,NULL,BDV,BDV,Office Administration (Dept),Responsible for providing a wide range of general services and administrative support in the achievement of the team's objectives.,NULL,NULL,NULL
175,NULL,CAB,CAB,Office Administration (Dept),Responsible for supporting the Vice Chairman in ensuring the stability and alignment of the unit to achieve organizational success.,NULL,NULL,NULL
176,NULL,FIN,FIN,Office Administration (Dept),Responsible for providing a wide range of general services and administrative support in the achievement of the Chief Finance Officer's objectives.,NULL,NULL,NULL
177,NULL,LEG,LEG,Office Administration (Dept),Responsible for providing general administrative and office support to the team to facilitate smooth and efficient departmental operations.,NULL,NULL,NULL
178,NULL,OCEO,OCEO,Payables Process Support (Dept),Responsible for providing support with handling all financial transactions for the department, in accordance with standard processing guidelines, timelines, and approved budget.,NULL,NULL,NULL
179,NULL,OCEO,OCEO,Payables Processing (Dept),Responsible for handling all financial transactions for the department, in accordance with standard processing guidelines, timelines, and approved budget.,NULL,NULL,NULL
180,NULL,LEG,LEG,Payment Processing & Petty Cash Management,Responsible for managing all financial transactions of the department, adhering to standard processing guidelines, timelines, and approved budget.,NULL,NULL,NULL
181,NULL,FIN,FIN,People Management Support,Responsible for supporting the department head in ensuring the stability and alignment of the team to achieve organizational success.,NULL,NULL,NULL
182,NULL,OCEO,OCEO,Personal Administration,Responsible for providing a wide range of high-level administrative support to the President and Chief Executive Officer in one's personal endeavors in an efficient, organized and timely manner.,NULL,NULL,NULL
183,NULL,CAB,CAB,Personal Administration,Responsible for providing a wide range of high-level administrative support to the Vice Chairman in one's personal endeavors in an efficient, organized, and timely manner.,NULL,NULL,NULL
184,NULL,BDV,BDV,Petty Cash Disbursement,Responsible for handling all financial transactions for the department, in accordance with standard processing guidelines, timelines, and approved budget.,NULL,NULL,NULL
185,NULL,FIN,FIN,Petty Cash Disbursement,Responsible for handling all financial transactions for the department, in accordance with standard processing guidelines, timelines, and approved budget.,NULL,NULL,NULL
186,NULL,OCEO,OCEO,Procurement Support,Responsible for supporting the procurement activities of the Bauhinia Project, including vendor sourcing, preparation of price comparisons, and coordination with vendors throughout the procurement process.,NULL,NULL,NULL
187,NULL,BDV,BDV,Project Development,Responsible for developing the project with consultants, as aligned with the business case, providing necessary support in creating business opportunities, and ensuring milestones are achieved in a timely manner until the handover of the project to a new business unit.,NULL,NULL,NULL
188,NULL,CAB,CAB,Public Policy & Monitoring,Responsible for keeping corporate informed and prepared for national and local issues and policy changes that may impact the Company and its group.,NULL,NULL,NULL
189,NULL,BDV,BDV,Records Management,Responsible for managing information and ensuring that file management guidelines are met.,NULL,NULL,NULL
190,NULL,CAB,CAB,Risk Management,Responsible for supporting the risk culture of the organization and managing risks in one's department.,NULL,NULL,NULL
191,NULL,CAB,CAB,Stakeholder Relations,Responsible for building, enhancing, and maintaining relationships with corporate stakeholders to protect and advance Company's interests, developing and maintaining a healthy stakeholder database for the Company and its group in the process.,NULL,NULL,NULL
192,NULL,HRD,TA/OPS,Talent Onboarding & Integration,Responsible for implementing onboarding activities, ensuring new employees are able to acclimatize them into Company culture and are equipped to perform their job effectively.,NULL,NULL,NULL
193,NULL,HRD,TA/OPS,Talent Onboarding & Retention ,Responsible for ensuring appropriate methods and tools are used for the effective onboarding of new employees and executives to acclimatize them into Company culture and are equipped to perform their job effectively.,NULL,NULL,NULL
194,NULL,CAB,CAB,Technical Services Support,Responsible for supporting the management in facilitating the strategic planning and implementation monitoring, enterprise risk management program, and business process review of assigned business unit.,NULL,NULL,NULL
CSV;

        $lines = preg_split("/(\r\n|\n|\r)/", trim($csv));
        // Remove header
        $header = str_getcsv(array_shift($lines));

        $rows = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || preg_match('/^,+$/', $line)) {
                continue;
            }
            $cols = str_getcsv($line);
            if (count($cols) < 6) {
                continue;
            }
            [$id, $subfunction_position_id, $department, $business_unit, $kra, $kra_description] = $cols;

            // Normalize NULL values
            $subfunction_position_id = (strtoupper((string) $subfunction_position_id) === 'NULL' || $subfunction_position_id === '') ? null : (int) $subfunction_position_id;
            $department = (strtoupper((string) $department) === 'NULL' || $department === '') ? null : $department;
            $business_unit = (strtoupper((string) $business_unit) === 'NULL' || $business_unit === '') ? null : $business_unit;
            $kra = (strtoupper((string) $kra) === 'NULL' || $kra === '') ? null : $kra;
            $kra_description = (strtoupper((string) $kra_description) === 'NULL' || $kra_description === '') ? null : $kra_description;

            $rows[] = [
                'subfunction_position_id' => $subfunction_position_id,
                'department' => $department ?? '',
                'business_unit' => $business_unit ?? '',
                'kra' => $kra ?? '',
                'kra_description' => $kra_description,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert in chunks to avoid large single insert
        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('job_profile_kras')->insert($chunk);
        }
    }
}
