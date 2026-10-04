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
                                    <i class='bi bi-file-earmark-text fs-3'></i>
                                </div>
                                <div>
                                    <h1 class="text-dark fw-bold display-6 mb-1">Terms and Conditions</h1>
                                    <p class="text-muted mb-0 text-center">Last updated: 4 October 2026</p>
                                </div>
                            </div>
                        </header>

                        <article class="text-dark" style="line-height: 1.8;">
                            <p>
                                Welcome to <strong>{{ config('app.name', 'Blog App') }}</strong>. By accessing or using this website, you agree to be bound by these Terms and Conditions. If you disagree with any part of these terms, you must refrain from using our platform and its associated services.
                            </p>

                            <ol class="ps-3 d-flex flex-column gap-3 mt-4">
                                <li>
                                    <strong>Account Registration & Roles</strong>
                                    <p class="mb-2 mt-1">
                                        Our platform supports email registration and Google OAuth sign-in. By creating an account, you agree to:
                                    </p>
                                    <ol style="list-style: lower-alpha;">
                                        <li>Provide truthful, current, and complete details during registration and profile personalization.</li>
                                        <li>Maintain the security and confidentiality of your credentials.</li>
                                        <li>Comply with role-based access rules:
                                            <ul class="mt-1">
                                                <li><strong>Admin:</strong> Has full privilege to manage categories, oversee all articles, moderate reported comments, and handle user permissions.</li>
                                                <li><strong>User:</strong> Has rights to create, edit, or delete their own posts, personalize their profile, and interact with the community.</li>
                                            </ul>
                                        </li>
                                    </ol>
                                </li>

                                <li>
                                    <strong>User-Generated Content & Code of Conduct</strong>
                                    <p class="mb-2 mt-1">
                                        You retain ownership of the content you publish. However, you grant {{ config('app.name', 'Blog App') }} a non-exclusive license to host, format, and display your contributions. You agree not to post content that:
                                    </p>
                                    <ol style="list-style: lower-alpha;">
                                        <li>Contains hate speech, defamation, harassment, obscenity, or personal attacks.</li>
                                        <li>Infringes on intellectual property, trademarks, or proprietary rights of others.</li>
                                        <li>Distributes unauthorized commercial messages, repetitive spam, or malicious software.</li>
                                    </ol>
                                </li>

                                <li>
                                    <strong>Community Interactions & Comment Moderation</strong>
                                    <p class="mb-2 mt-1">
                                        To preserve constructive discussions, our interactive tools operate under clear guidelines:
                                    </p>
                                    <ol style="list-style: lower-alpha;">
                                        <li>
                                            <strong>Likes, Dislikes, and Follows:</strong> Voting on posts or comments and author following must represent genuine human interaction. Automated voting or bot activity is strictly prohibited.
                                        </li>
                                        <li>
                                            <strong>Reporting System:</strong> Users may submit reports on inappropriate comments. Administrators reserve the right to review, edit, unpublish, or delete reported comments at their sole discretion.
                                        </li>
                                    </ol>
                                </li>

                                <li>
                                    <strong>Media Uploads & External Cloud Storage</strong>
                                    <p class="mt-1">
                                        When you upload images such as avatars, profile banners, or article thumbnails, they are hosted using cloud integrations including the Google Drive API. You confirm you own all necessary rights to any uploaded media and will not upload copyright-infringing or unlawful imagery.
                                    </p>
                                </li>

                                <li>
                                    <strong>Account Suspension & Termination</strong>
                                    <p class="mt-1">
                                        We reserve the right to restrict, suspend, or terminate account access without prior notice if we detect violations of these terms, abusive behavior, or actions that compromise platform integrity.
                                    </p>
                                </li>

                                <li>
                                    <strong>Disclaimer of Warranties & Limitation of Liability</strong>
                                    <p class="mt-1">
                                        The application is provided on an "AS IS" and "AS AVAILABLE" basis. While we apply secure database practices and middleware defenses, we make no guarantees that platform availability will remain completely uninterrupted or free from runtime anomalies.
                                    </p>
                                </li>

                                <li>
                                    <strong>Modifications to Terms</strong>
                                    <p class="mt-1">
                                        We may update or revise these Terms and Conditions at any time. Changes become effective immediately upon posting, with the latest revision date indicated at the top of this document.
                                    </p>
                                </li>

                                <li>
                                    <strong>Contact Us</strong>
                                    <p class="mt-1 mb-0">
                                        If you have questions, concerns, or requests regarding this Terms and Conditions, please contact us at: <a href="mailto:ikmalfalah@gmail.com" class="text-decoration-none text-primary">ikmalfalah@gmail.com</a>
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
