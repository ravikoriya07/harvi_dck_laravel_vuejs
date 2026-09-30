<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Starting content for the Terms of Use and Privacy Policy pages.
 * Admins edit it under Website → Legal Pages; existing rows are never overwritten.
 */
return new class extends Migration
{
    private const CONTACT_LINKS = '<a href="mailto:info@thedck.com">info@thedck.com</a> or call <a href="tel:+442030931828">020 3093 1828</a>';

    private const COMPANY_DETAILS = 'We are a company registered in England with company number 6645493, and our registered office is 8 Oakleighs, 630 High Road, Woodford Green, Essex, IG8 0PU.';

    public function up(): void
    {
        $now = now();

        foreach ([$this->termsOfUse(), $this->privacyPolicy()] as $page) {
            DB::table('legal_pages')->insertOrIgnore([
                ...$page,
                'sections' => json_encode($page['sections']),
                'last_updated_at' => '2026-09-30',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('legal_pages')->whereIn('slug', ['terms-of-use', 'privacy-policy'])->delete();
    }

    /**
     * @return array{slug: string, title: string, meta_description: string, intro: string, sections: list<array{heading: string, body: string}>}
     */
    private function termsOfUse(): array
    {
        return [
            'slug' => 'terms-of-use',
            'title' => 'Terms of Use',
            'meta_description' => 'The terms that apply when you use the DCK Construction website, including acceptable use, intellectual property and our liability.',
            'intro' => '<p>These terms of use set out the rules for using the DCK Construction website. By using our website, you confirm that you accept these terms and agree to comply with them. If you do not agree, please do not use our website.</p>',
            'sections' => [
                [
                    'heading' => 'About us',
                    'body' => '<p>This website is operated by D C K Construction Limited ("DCK", "we", "us" or "our"). ' . self::COMPANY_DETAILS . ' Our VAT number is 944613909.</p>'
                        . '<p>To contact us, please email ' . self::CONTACT_LINKS . '.</p>',
                ],
                [
                    'heading' => 'Other terms that apply',
                    'body' => '<p>Our <a href="/privacy-policy">Privacy Policy</a> explains how we use any personal information you give us, including when you apply for a job through this website. It forms part of these terms.</p>',
                ],
                [
                    'heading' => 'Changes to these terms',
                    'body' => '<p>We may revise these terms at any time by updating this page. Please check it from time to time, as the version in force when you use our website applies to you. The date at the top of this page shows when these terms were last updated.</p>',
                ],
                [
                    'heading' => 'Changes to and availability of our website',
                    'body' => '<p>We may update or change our website at any time, for example to reflect changes to our services or projects. Our website is made available free of charge. We do not guarantee that it, or any content on it, will always be available or uninterrupted, and we may suspend or withdraw all or part of it for business or operational reasons.</p>',
                ],
                [
                    'heading' => 'Intellectual property',
                    'body' => '<p>We own, or are licensed to use, all intellectual property rights in our website and the material on it, including text, photographs, project images, videos, logos and designs. These works are protected by copyright and other laws.</p>'
                        . '<p>You may view, print or download extracts of pages for your own use or to share information about DCK within your organisation. You must not modify any material, use any images or videos separately from the accompanying text, or use any part of our website for commercial purposes without our written permission.</p>',
                ],
                [
                    'heading' => 'Acceptable use',
                    'body' => '<p>You may use our website only for lawful purposes. You must not:</p><ul>'
                        . '<li><p>use it in any way that breaches any applicable local, national or international law or regulation;</p></li>'
                        . '<li><p>send, upload or use any material that is unlawful, misleading or offensive;</p></li>'
                        . '<li><p>submit false or misleading information, including in a job application;</p></li>'
                        . '<li><p>attempt to gain unauthorised access to our website, the server it is stored on or any connected system;</p></li>'
                        . '<li><p>knowingly introduce viruses, trojans, worms or any other malicious or technologically harmful material;</p></li>'
                        . '<li><p>use automated tools to copy or extract content from our website without our permission.</p></li>'
                        . '</ul>',
                ],
                [
                    'heading' => 'Information on our website',
                    'body' => '<p>The content on our website is provided for general information only. It is not intended to be advice on which you should rely. Although we make reasonable efforts to keep it up to date, we make no representations or guarantees that the content is accurate, complete or current.</p>'
                        . '<p>Project descriptions, photographs and videos are shown for illustration and may not reflect the final finish or current condition of a project.</p>',
                ],
                [
                    'heading' => 'Job vacancies and applications',
                    'body' => '<p>Vacancies shown on our website may be changed, filled or withdrawn at any time without notice. Submitting an application does not create an offer or a guarantee of employment. Any offer of employment will be made in writing and will be subject to our usual recruitment checks.</p>'
                        . '<p>By applying, you confirm that the information you provide is accurate and complete. We will use it as described in our <a href="/privacy-policy">Privacy Policy</a>.</p>',
                ],
                [
                    'heading' => 'Links to other websites',
                    'body' => '<p>Our website contains links to websites and resources provided by third parties, including our social media pages. These links are provided for your information only. We have no control over the content of those websites and accept no responsibility for them or for any loss or damage that may arise from your use of them.</p>',
                ],
                [
                    'heading' => 'Our responsibility for loss or damage',
                    'body' => '<p>Nothing in these terms excludes or limits our liability for death or personal injury caused by our negligence, for fraud or fraudulent misrepresentation, or for any other liability that cannot be excluded or limited by English law.</p>'
                        . '<p>To the extent permitted by law, we exclude all conditions, warranties and representations, whether express or implied, that may apply to our website or its content. We will not be liable for any loss or damage arising from your use of, or inability to use, our website, or from your use of or reliance on any content on it. In particular, we will not be liable for loss of profits, sales, business or revenue, business interruption, loss of anticipated savings, loss of business opportunity, goodwill or reputation, or any indirect or consequential loss.</p>',
                ],
                [
                    'heading' => 'Viruses',
                    'body' => '<p>We do not guarantee that our website will be secure or free from bugs or viruses. You are responsible for configuring your own technology to access our website and should use your own virus protection software.</p>',
                ],
                [
                    'heading' => 'Governing law',
                    'body' => '<p>These terms, their subject matter and their formation are governed by the laws of England and Wales. You and we both agree that the courts of England and Wales will have exclusive jurisdiction, except that if you live in Scotland or Northern Ireland you may also bring proceedings in your local courts.</p>',
                ],
                [
                    'heading' => 'Contact us',
                    'body' => '<p>If you have any questions about these terms, please email ' . self::CONTACT_LINKS . '.</p>',
                ],
            ],
        ];
    }

    /**
     * @return array{slug: string, title: string, meta_description: string, intro: string, sections: list<array{heading: string, body: string}>}
     */
    private function privacyPolicy(): array
    {
        return [
            'slug' => 'privacy-policy',
            'title' => 'Privacy Policy',
            'meta_description' => 'How DCK Construction collects, uses and protects your personal information, including job applications, cookies and your data protection rights.',
            'intro' => '<p>This Privacy Policy explains how D C K Construction Limited ("DCK", "we", "us" or "our") collects, uses and protects your personal information when you visit our website, contact us or apply for a job with us. We handle personal information in line with the UK General Data Protection Regulation (UK GDPR) and the Data Protection Act 2018.</p>',
            'sections' => [
                [
                    'heading' => 'Who we are',
                    'body' => '<p>D C K Construction Limited is the controller of your personal information. ' . self::COMPANY_DETAILS . '</p>'
                        . '<p>If you have any questions about this policy or how we use your information, please email ' . self::CONTACT_LINKS . '.</p>',
                ],
                [
                    'heading' => 'Information we collect',
                    'body' => '<p>We only collect the information we need. Depending on how you deal with us, this may include:</p><ul>'
                        . '<li><p><strong>Job applications:</strong> your name, email address, phone number, cover letter, CV and any other information you choose to include in your application.</p></li>'
                        . '<li><p><strong>Enquiries:</strong> your name, contact details and the content of any email, phone call or message you send us.</p></li>'
                        . '<li><p><strong>Business relationships:</strong> the contact details of people who work for our clients, suppliers and subcontractors.</p></li>'
                        . '<li><p><strong>Technical information:</strong> information your browser sends when you visit our website, such as your IP address, browser type and the pages you view, which our servers record in standard log files.</p></li>'
                        . '</ul>'
                        . '<p>We do not ask for special category information (for example, information about your health or ethnic origin) through this website. Please do not include it in your application unless we ask for it.</p>',
                ],
                [
                    'heading' => 'How we use your information',
                    'body' => '<p>We use your personal information to:</p><ul>'
                        . '<li><p>assess job applications, contact you about your application and manage our recruitment process;</p></li>'
                        . '<li><p>respond to your enquiries and provide the information you ask for;</p></li>'
                        . '<li><p>manage our relationships with clients, suppliers and subcontractors and deliver our projects;</p></li>'
                        . '<li><p>keep our website secure and working properly;</p></li>'
                        . '<li><p>meet our legal and regulatory obligations.</p></li>'
                        . '</ul>'
                        . '<p>We do not sell your personal information and we do not make decisions about you based solely on automated processing.</p>',
                ],
                [
                    'heading' => 'Our lawful basis for using your information',
                    'body' => '<p>Under UK data protection law we must have a lawful basis for using your personal information. We rely on:</p><ul>'
                        . '<li><p><strong>Contract:</strong> where we need your information to take steps you have asked for before entering into a contract with you, such as considering your job application.</p></li>'
                        . '<li><p><strong>Legitimate interests:</strong> where we use your information to run our business, respond to enquiries and keep our website secure, provided your interests and rights do not override those interests.</p></li>'
                        . '<li><p><strong>Legal obligation:</strong> where we must use your information to comply with the law, for example right-to-work checks for successful candidates.</p></li>'
                        . '<li><p><strong>Consent:</strong> where you have given us permission. You can withdraw your consent at any time.</p></li>'
                        . '</ul>',
                ],
                [
                    'heading' => 'Who we share your information with',
                    'body' => '<p>We only share your personal information where it is necessary. This may include:</p><ul>'
                        . '<li><p>service providers who help us run our business, such as website hosting, IT and email providers, who may only use your information on our instructions;</p></li>'
                        . '<li><p>professional advisers, such as lawyers, accountants and insurers;</p></li>'
                        . '<li><p>clients or main contractors, where this is needed to deliver a project (for example, site access or accreditation checks);</p></li>'
                        . '<li><p>regulators, law enforcement agencies or other authorities where the law requires us to.</p></li>'
                        . '</ul>',
                ],
                [
                    'heading' => 'International transfers',
                    'body' => '<p>We aim to keep your personal information within the UK. Where one of our service providers processes it outside the UK, we make sure appropriate safeguards are in place, such as UK adequacy regulations or the International Data Transfer Agreement approved by the Information Commissioner.</p>',
                ],
                [
                    'heading' => 'How long we keep your information',
                    'body' => '<p>We keep personal information only for as long as we need it for the purpose we collected it for, including to meet any legal, accounting or reporting requirements. For example:</p><ul>'
                        . '<li><p>applications from unsuccessful candidates are kept for a limited period after the recruitment process ends, so that we can answer any questions about our decision, and are then securely deleted;</p></li>'
                        . '<li><p>if you join us, your application becomes part of your employee record;</p></li>'
                        . '<li><p>correspondence about an enquiry is kept for as long as we need it to deal with the enquiry and any follow-up.</p></li>'
                        . '</ul>',
                ],
                [
                    'heading' => 'How we protect your information',
                    'body' => '<p>We use appropriate technical and organisational measures to protect your personal information against loss, misuse and unauthorised access, and we limit access to people who need it for their work.</p>'
                        . '<p>No method of sending information over the internet is completely secure, but we take reasonable steps to protect the information you send us.</p>',
                ],
                [
                    'heading' => 'Your rights',
                    'body' => '<p>You have the right to:</p><ul>'
                        . '<li><p>ask for a copy of the personal information we hold about you;</p></li>'
                        . '<li><p>ask us to correct information that is inaccurate or incomplete;</p></li>'
                        . '<li><p>ask us to delete your information;</p></li>'
                        . '<li><p>ask us to restrict how we use your information;</p></li>'
                        . '<li><p>object to us using your information where we rely on legitimate interests;</p></li>'
                        . '<li><p>ask us to transfer your information to another organisation;</p></li>'
                        . '<li><p>withdraw your consent at any time, where we rely on consent.</p></li>'
                        . '</ul>'
                        . '<p>Some of these rights only apply in certain circumstances. To make a request, please use the details in the "Contact us and complaints" section below. We will usually respond within one month, and there is normally no charge.</p>',
                ],
                [
                    'heading' => 'Cookies',
                    'body' => '<p>Our website only uses cookies that are strictly necessary for it to work: a session cookie and a security cookie that protects our forms from misuse. These cookies do not identify you personally and expire after a short period.</p>'
                        . '<p>We do not currently use analytics or advertising cookies. If this changes, we will update this policy and ask for your consent where required.</p>',
                ],
                [
                    'heading' => 'Third-party services and links',
                    'body' => '<p>Our website uses fonts provided by Google Fonts, which means your browser connects to Google\'s servers and shares your IP address with Google. Some pages also let you play videos hosted on YouTube, which may set its own cookies when you play a video.</p>'
                        . '<p>Our website also links to other websites and social media platforms, including LinkedIn, Instagram, Facebook and YouTube. We are not responsible for how those sites handle your information, so please read their privacy policies.</p>',
                ],
                [
                    'heading' => 'Changes to this policy',
                    'body' => '<p>We may update this policy from time to time. The latest version will always be available on this page, and the date at the top of this page shows when it was last updated.</p>',
                ],
                [
                    'heading' => 'Contact us and complaints',
                    'body' => '<p>If you have any questions about this policy or wish to exercise your rights, please contact us:</p><ul>'
                        . '<li><p>Email: <a href="mailto:info@thedck.com">info@thedck.com</a></p></li>'
                        . '<li><p>Phone: <a href="tel:+442030931828">020 3093 1828</a></p></li>'
                        . '<li><p>Post: D C K Construction Limited, 8 Oakleighs, 630 High Road, Woodford Green, Essex, IG8 0PU</p></li>'
                        . '</ul>'
                        . '<p>If you are unhappy with how we have handled your information, you have the right to complain to the Information Commissioner\'s Office (ICO), the UK\'s data protection regulator, at <a href="https://ico.org.uk/make-a-complaint/" target="_blank" rel="noopener noreferrer">ico.org.uk/make-a-complaint</a> or by calling 0303 123 1113. We would, however, appreciate the chance to deal with your concerns first.</p>',
                ],
            ],
        ];
    }
};
