@extends('layouts.front')
@section('style')
@if (isset($metadata['meta_title']))
<meta name="title" content="{{ $metadata['meta_title'] }}">
<title>{{ $metadata['meta_title'] }}</title>
@else
<title>Storia Foods &#8211; Home</title>
@endif

@if (isset($metadata['meta_description']))
<meta name="description" content="{{ $metadata['meta_description'] }}">
@else
<meta name="description" content="Storia Foods &#8211; Home">
@endif
<style>
.rest {
        font-family: Lato;
    }

    .rest h2 {
        font-family: Lato;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .rest p strong {
        border-bottom: 1px solid #000;
    }
</style>
@endsection
@section('content')

<div id="main">
    <div class="container">
        <div class="mb-5 rest">
            <h2 class="pb-2">Privacy Policy</h2>
            <p class="pt-3">Introduction to Privacy Policy</p>
            <b>Acceptance of Terms:</b> Your access to and use of this site is subject to the following Terms of Use.
            <br><br>
            This privacy policy (the &quot; PRIVACY POLICY&quot;) applies to your use of the website of Storia® hosted at
            www.shop.stroria.com (&quot; STRORIA®&quot; or &quot; WEBSITE&quot;) and to the Services (as defined under the Storia®
            &quot;Terms of Use&quot;) but does not apply to any third party websites that may be linked to Storia®, or any
            relationships you may have with the businesses listed on Storia®.
            <br><br>
            The term &quot;PERSONAL INFORMATION&quot; means information that you provide to us which personally
            identifies you to be contacted or identified, such as your name, phone number, email address, and any
            other data that is tied to such information. Our practices and procedures in relation to the collection and
            use of Personal Information have been set-out below in order to ensure safe usage of the Website for
            you.
            <br><br>
            We have implemented reasonable security practices and procedures that are commensurate with the
            information assets being protected and with the nature of our business. While we try our best to
            provide security that is better than the industry standards, because of the inherent vulnerabilities of the
            internet, we cannot ensure or warrant complete security of all information that is being transmitted to
            us by you. By visiting this Website, you agree and acknowledge to be bound by this Privacy Policy and
            you hereby consent that we will collect, use, process and share your Personal Information in the manner
            set out herein below. If you do not agree with these terms, do not use the Website.
            <br><br>
            It is clarified that the terms and conditions that are provided separately, form an integral part of your
            use of this Website and should be read in conjunction with this Privacy Policy.
            <br><br>
            Information we collect and how we use it: We collect, receive and store your Personal Information. If
            you provide your third-party account credentials (&quot; THIRD PARTY ACCOUNT INFORMATION&quot;) to us, you
            understand that some content and information in those accounts may be transmitted to your account
            with us if you authorize such transmissions and that Third Party Account Information transmitted to us
            shall be covered by this Privacy Policy. You may opt to not provide us with certain information, however
            that will restrict you from registering with us or availing some of our features and services.
            <br><br>
            We use commercially reasonable efforts to ensure that the collection of Personal Information is limited
            to that which is necessary to fulfill the purposes identified below. If we use or plan to use your
            information in a manner different than the purpose for which it is collected, then we will ask you for
            your consent prior to such use.
            <br><br>
            The Personal Information collected will be used only for the purpose of enabling you to use the services
            provided by us, to help promote a safe service, calibrate consumer interest in our products and services,
            inform you about online offers and updates, troubleshoot problems, customize User experience, detect
            and protect us against error, fraud and other criminal activity, collect money, enforce our terms and
            conditions, and as otherwise described to you at the time of collection of such information.
            <br><br>
            Feedback: If you contact us to provide feedback, register a complaint, or ask a question, we will record
            any Personal Information and other content that you provide in your communication so that we can
            effectively respond to your communication.
            <br><br>
            Activity: We record information relating to your use of Storia®, such as the searches you undertake, the
            pages you view, your browser type, IP address, location, requested URL, referring URL, and timestamp
            information. We use this type of information to administer Storia® and provide the highest possible level
            of security and service to you. We also use this information in the aggregate to perform statistical
            analyses of User behavior and characteristics in order to measure interest in and use of the various
            areas of Storia®. However, you cannot be identified from this aggregate information.
            <br><br>
            We own all the intellectual property rights associated with the Website and its contents. No right, title
            or interest in any downloaded material is transferred to you as a result of any such downloading or
            copying. The Website is protected by copyright as a collective work and/ or compilation (meaning the
            collection, arrangement, and assembly) of all the content on this Website, pursuant to applicable law.
            <br><br>
            Our logos, product and service marks and/ or names, trademarks, copyrights and other intellectual
            property, whether registered or not (&quot; OUR IP&quot;) are exclusively owned by us. Without our prior written
            permission, you agree to not display and/ or use Our IP in any manner. Nothing contained in this
            Website or the content, should be construed as granting, in any way to the User, any license or right or
            interest whatsoever, in and/ or to Our IP, without our express written permission.
            <br><br>
            Cookies: We send cookies to your computer in order to uniquely identify your browser and improve the
            quality of our service. The term &quot;cookies&quot; refers to small pieces of information that a website sends to
            your computer&#39;s hard drive while you are viewing the site. We may use both session cookies (which
            expire once you close your browser) and persistent cookies (which stay on your computer until you
            delete them). Persistent cookies can be removed by following your browser help file directions. If you
            choose to disable cookies, some areas of Storia® may not work properly or at all. Storia® uses third party
            tools, who may collect anonymous information about your visits to Storia® using cookies, and
            interaction with Storia® products and services. Such third parties may also use information about your
            visits to Storia® products and services and other web sites to target advertisements for Storia® products

            and services. No Personal Information is collected or used in this process. These third parties do not
            know or have access to the name, phone number, address, email address, or any Personal Information
            about Storia®’s Users. Storia® Users can opt-out of sharing this information with third parties by
            deactivating cookies, the process of which varies from browser to browser. Please refer to the help file
            of your browser to understand the process of deactivating cookies on your browser.
            <br><br>
            Enforcement: We may use the information we collect in connection with your use of Storia® (including
            your Personal Information) in order to investigate, enforce, and apply our terms and conditions and
            Privacy Policy.
            <br><br>
            Links: References on this Website to any names, marks, products or services of third parties or
            hyperlinks to third party websites or information are provided solely for your convenience and do not in
            any way constitute or imply our endorsement, sponsorship or recommendation of the third party,
            information, product or service. Except as set forth herein, we do not share your Personal Information
            with those third parties, and are not responsible for their privacy practices. We suggest you read the
            privacy policies on all such third party websites.
            <br><br>
            Security: We use industry standard measures to protect the Personal Information that is stored in our
            database. We limit the access to your Personal Information to those employees and contractors who
            need access to perform their job function, such as our customer service personnel. You hereby
            acknowledge that Storia® is not responsible for any intercepted information sent via the internet, and
            you hereby release us from any and all claims arising out of or related to the use of intercepted
            information in any unauthorized manner.
            <br><br>
            Terms and modifications to this Privacy Policy: Our Privacy Policy is subject to change at any time
            without notice. To make sure you are aware of any changes, please review this policy periodically. These
            changes will be effective immediately on the Users of Storia®. Please note that at all times you are
            responsible for updating your Personal Information, including to provide us with your most current e-
            mail address.
            <br><br>
            If you do not wish to permit changes in our use of your Personal Information, you must notify us
            promptly that you wish to deactivate your account with us. Continued use of Storia® after any change/
            amendment to this Privacy Policy shall indicate your acknowledgement of such changes and agreement
            to be bound by the terms and conditions of such changes.
            <br><br>
            Applicable law: Your use of this Website will be governed by and construed in accordance with the laws
            of India. The Users agree that any legal action or proceedings arising out of your use may be brought
            <br><br>
            exclusively in the competent courts/ tribunals having jurisdiction in Mumbai in India and irrevocably
            submit themselves to the jurisdiction of such courts/ tribunals.
            <br><br>
            Complaints and Grievance Redressal: Any complaints or concerns in relation to your Personal
            Information or content of this Website or any dispute or breach of confidentiality or any proprietary
            rights of User during use of the Website or any intellectual property of any User should be immediately
            write to customercare@storiafoods.com
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection
