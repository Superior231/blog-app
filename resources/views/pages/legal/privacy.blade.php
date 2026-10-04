@extends('layouts.main')

@section('content')
    <section class="legal py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm p-4 p-md-5">
                        <header class="border-bottom pb-4 mb-4 d-flex justify-content-center">
                            <div class="d-flex align-items-center gap-1">
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
                                    <i class='bi bi-shield-lock fs-3'></i>
                                </div>
                                <div>
                                    <h1 class="text-dark fw-bold display-6 mb-1">Privacy Policy</h1>
                                    <p class="text-muted mb-0 text-center">Last updated: 4 October 2026</p>
                                </div>
                            </div>
                        </header>

                        <article class="text-dark" style="line-height: 1.8;">
                            <p>
                                Welcome to <strong>{{ config('app.name', 'Blog App') }}</strong>. We respect your privacy and
                                are committed to protecting your personal data. This Privacy Policy explains how we collect,
                                use, disclose, and safeguard your information when you access or use our web application.
                            </p>

                            <ol class="ps-3 d-flex flex-column gap-3 mt-4">
                                <li class="text-dark">
                                    <strong>Information We Collect</strong>
                                    <p class="mb-2 mt-1">
                                        We collect several types of information to provide and enhance our
                                        services to you:
                                    </p>
                                    <ol style="list-style: lower-alpha;">
                                        <li>
                                            <strong>Account Information:</strong> When registering with email or through OAuth,
                                            we collect your name, email address, profile avatar, and bio/description.
                                        </li>
                                        <li>
                                            <strong>Google OAuth Data:</strong> When you choose to <em>Log in with Google</em>, we retrieve your basic profile information (name, email address, profile picture URL, and Google ID) solely for authentication and profile setup.
                                        </li>
                                        <li>
                                            <strong>Content & User Activity:</strong> Articles, comments, replies, comment
                                            reports, social links (e.g., GitHub, LinkedIn, X, Facebook, Instagram, YouTube),
                                            and likes/dislikes on posts or comments.
                                        </li>
                                        <li>
                                            <strong>Media & Uploaded Files:</strong> Avatars, profile banners, and article
                                            thumbnails uploaded to our service.
                                        </li>
                                    </ol>
                                </li>

                                <li>
                                    <strong class="text-dark">How We Use Google Drive API & Third-Party Services</strong>
                                    <p class="mb-2 mt-1">
                                        Our application integrates with third-party service providers to
                                        deliver robust functionality:
                                    </p>
                                    <ol style="list-style: lower-alpha;">
                                        <li>
                                            <strong>Google Drive API:</strong> We utilize Google Drive API storage services
                                            specifically to store, retrieve, and host media files you upload, including
                                            avatars, profile banners, and article thumbnail images. We do not inspect,
                                            access, alter, or share non-application files from your Google Drive.
                                        </li>
                                        <li>
                                            <strong>Google API Limited Use Disclosure:</strong> Our use and transfer of
                                            information received from Google APIs to any other app will adhere to the
                                            <a href="https://developers.google.com/terms/api-services-user-data-policy"
                                                target="_blank" rel="noopener noreferrer"
                                                class="text-decoration-none text-primary">Google API Services User Data Policy
                                            </a>, including the Limited Use requirements.
                                        </li>
                                        <li>
                                            <strong>Social Media Sharing:</strong> When using the share buttons (Facebook,
                                            X/Twitter, Email), only public article URLs and titles are passed via standard
                                            web intent dialogs.
                                        </li>
                                    </ol>
                                </li>

                                <li>
                                    <strong class="text-dark">Database Storage & Security</strong>
                                    <p class="mb-2 mt-1">
                                        All core data including user accounts, articles, categorization,
                                        and engagement metrics is stored in a secure relational database (MySQL). We
                                        implement strict industry standard security safeguards, including:
                                    </p>
                                    <ol style="list-style: lower-alpha;">
                                        <li>Password hashing for email authentication credentials.</li>
                                        <li>Role-based access control (RBAC) enforced via application middleware to ensure users only access permitted resources.</li>
                                    </ol>
                                </li>

                                <li>
                                    <strong class="text-dark">Publicly Visible Profile Data</strong>
                                    <p class="mt-1">
                                        By creating an account, your public author profile (display name,
                                        avatar, banner, bio, social media handles, published articles, and follower counts)
                                        will be visible to other registered users and public visitors.
                                    </p>
                                </li>

                                <li>
                                    <strong class="text-dark">Data Retention & Your Rights</strong>
                                    <p class="mb-2 mt-1">
                                        We retain your personal information as long as your account remains
                                        active. You maintain the right to:
                                    </p>
                                    <ol style="list-style: lower-alpha;">
                                        <li>Access, update, or edit your profile details and social links directly via your dashboard.</li>
                                        <li>Edit or delete articles and comments you have published.</li>
                                        <li>Request full deletion of your account and associated personal data by contacting our support team.</li>
                                    </ol>
                                </li>

                                <li>
                                    <strong class="text-dark">Cookies & Local Storage</strong>
                                    <p class="mt-1">
                                        We use session cookies and local storage tokens strictly necessary to
                                        keep you authenticated, maintain user session state, and power responsive search
                                        features (via Laravel Livewire).
                                    </p>
                                </li>

                                <li class="text-dark">
                                    <strong>Modifications to Privacy Policy</strong>
                                    <p class="mt-1">
                                        We may update or revise these Privacy Policy at any time. Changes become effective immediately upon posting, with the latest revision date indicated at the top of this document.
                                    </p>
                                </li>

                                <li>
                                    <strong class="text-dark">Contact Us</strong>
                                    <p class="mt-1 mb-0">
                                        If you have questions, concerns, or requests regarding this Privacy
                                        Policy, please contact us at: <a href="mailto:ikmalfalah@gmail.com" class="text-decoration-none text-primary">ikmalfalah@gmail.com</a>
                                    </p>
                                </li>
                            </ol>
                        </article>

                        <footer class="border-top pt-4 mt-4 d-flex justify-content-end">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill">Back to Home</a>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
