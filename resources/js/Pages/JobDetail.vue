<template>
    <Head :title="job.title + ' — Current Jobs'" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-job-detail">

            <!-- Hero -->
            <section class="jd-hero">
                <img
                    class="jd-hero-photo"
                    src="/assets/images/bg-2_H-e1760689052181_1_11zon.avif"
                    alt=""
                    fetchpriority="high"
                    loading="eager"
                    decoding="async"
                />
                <div class="jd-hero-overlay"></div>
                <div class="container">
                    <div class="jd-hero-content">
                        <div class="jd-hero-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="2" y="7" width="20" height="14" rx="2"/>
                                <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                            </svg>
                        </div>
                        <span v-if="job.category" class="jd-hero-category">{{ job.category }}</span>
                        <h1 class="jd-hero-title">{{ job.title }}</h1>
                        <p class="jd-hero-meta">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            Posted {{ job.posted_at }} &nbsp;·&nbsp; {{ job.posted_date }}
                        </p>
                        <nav class="jd-breadcrumb" aria-label="Breadcrumb">
                            <AppLink href="/" class="jd-breadcrumb-link">Home</AppLink>
                            <span class="jd-breadcrumb-sep">/</span>
                            <AppLink href="/jobs" class="jd-breadcrumb-link">Current Jobs</AppLink>
                            <span class="jd-breadcrumb-sep">/</span>
                            <span class="jd-breadcrumb-current">{{ job.title }}</span>
                        </nav>
                    </div>
                </div>
            </section>

            <!-- Body -->
            <section class="jd-body">
                <div class="container">
                    <div class="jd-layout">

                        <!-- Main content -->
                        <div class="jd-main">
                            <div class="jd-card">
                                <h2 class="jd-section-title">Job Description</h2>
                                <div class="jd-description" v-html="job.description"></div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <aside class="jd-sidebar">
                            <div class="jd-sidebar-card">
                                <h3 class="jd-sidebar-title">Job Overview</h3>
                                <ul class="jd-overview-list">
                                    <li v-if="job.category" class="jd-overview-item">
                                        <span class="jd-overview-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 10h16M4 14h8"/></svg>
                                        </span>
                                        <div>
                                            <span class="jd-overview-label">Category</span>
                                            <span class="jd-overview-value">{{ job.category }}</span>
                                        </div>
                                    </li>
                                    <li class="jd-overview-item">
                                        <span class="jd-overview-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                        </span>
                                        <div>
                                            <span class="jd-overview-label">Date Posted</span>
                                            <span class="jd-overview-value">{{ job.posted_date }}</span>
                                        </div>
                                    </li>
                                    <li class="jd-overview-item">
                                        <span class="jd-overview-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                        </span>
                                        <div>
                                            <span class="jd-overview-label">Location</span>
                                            <span class="jd-overview-value">London, UK</span>
                                        </div>
                                    </li>
                                </ul>

                                <button class="jd-apply-btn" @click="openModal">
                                    Apply Now
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </button>

                                <AppLink href="/jobs" class="jd-back-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                                    Back to all jobs
                                </AppLink>
                            </div>
                        </aside>

                    </div>
                </div>
            </section>

        </div>
    </MainLayout>

    <!-- Apply Now Modal -->
    <Teleport to="body">
        <Transition name="modal-fade">
            <div v-if="modalOpen" class="jd-modal-backdrop" @click.self="closeModal">
                <div class="jd-modal" role="dialog" aria-modal="true" aria-labelledby="jd-modal-title">
                    <div class="jd-modal-header">
                        <div>
                            <p class="jd-modal-subtitle">You are applying for</p>
                            <h2 id="jd-modal-title" class="jd-modal-title">{{ job.title }}</h2>
                            <span v-if="job.category" class="jd-modal-category">{{ job.category }}</span>
                        </div>
                        <button class="jd-modal-close" @click="closeModal" aria-label="Close modal">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="jd-modal-body">
                        <h3 class="jd-modal-form-heading">Apply For This Job</h3>

                        <form class="jd-apply-form" novalidate @submit.prevent="submitApplication">
                            <div class="jd-form-row">
                                <label class="jd-form-label" for="jd-name">Name <span class="jd-form-required">*</span></label>
                                <input id="jd-name" v-model="form.name" type="text" class="jd-form-input" placeholder="Your full name" />
                                <p v-if="errors.name" class="jd-form-error">{{ errors.name }}</p>
                            </div>

                            <div class="jd-form-row">
                                <label class="jd-form-label" for="jd-email">Email <span class="jd-form-required">*</span></label>
                                <input id="jd-email" v-model="form.email" type="email" class="jd-form-input" placeholder="your@email.com" />
                                <p v-if="errors.email" class="jd-form-error">{{ errors.email }}</p>
                            </div>

                            <div class="jd-form-row">
                                <label class="jd-form-label" for="jd-phone">Phone <span class="jd-form-required">*</span></label>
                                <IntlTelInput
                                    v-model="form.phone"
                                    input-id="jd-phone"
                                    input-class="jd-form-input jd-phone-input"
                                    initial-country="gb"
                                />
                                <p v-if="errors.phone" class="jd-form-error">{{ errors.phone }}</p>
                            </div>

                            <div class="jd-form-row">
                                <label class="jd-form-label" for="jd-cover">Cover Letter <span class="jd-form-required">*</span></label>
                                <textarea id="jd-cover" v-model="form.cover_letter" class="jd-form-textarea" rows="5" placeholder="Tell us why you're a great fit for this role..."></textarea>
                                <p v-if="errors.cover_letter" class="jd-form-error">{{ errors.cover_letter }}</p>
                            </div>

                            <div class="jd-form-row">
                                <label class="jd-form-label" for="jd-resume">Attach Resume <span class="jd-form-required">*</span></label>
                                <div class="jd-file-wrap">
                                    <input id="jd-resume" ref="resumeInput" type="file" class="jd-file-input" accept=".pdf,.doc,.docx,.odt,.rtf,.txt" @change="handleFile" />
                                    <div class="jd-file-display" @click="resumeInput?.click()">
                                        <span class="jd-file-name">{{ form.resume_name || 'No file chosen' }}</span>
                                        <button type="button" class="jd-file-browse">Browse</button>
                                    </div>
                                    <p class="jd-file-hint">Accepted: PDF, DOC, DOCX, ODT, RTF, TXT</p>
                                </div>
                                <p v-if="errors.resume" class="jd-form-error">{{ errors.resume }}</p>
                            </div>

                            <div class="jd-form-actions">
                                <button type="button" class="jd-form-cancel" @click="closeModal">Cancel</button>
                                <button type="submit" class="jd-form-submit" :disabled="submitting">
                                    {{ submitting ? 'Submitting...' : 'Submit Application' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>

</template>

<script setup>
import { ref, reactive, watch } from 'vue';
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import AppLink from '@/Components/AppLink.vue';
import IntlTelInput from '@/Components/IntlTelInput.vue';
import { notifyError, notifySuccess } from '@/utils/toast';
import * as yup from 'yup';

const { job } = defineProps({
    job: { type: Object, required: true },
});

// ── Modal ────────────────────────────────────────────────────────────────────
const modalOpen   = ref(false);
const resumeInput = ref(null);
const submitting = ref(false);

const form = reactive({
    name: '', email: '', phone: '', cover_letter: '',
    resume: null, resume_name: '',
});

const errors = reactive({
    name: '',
    email: '',
    phone: '',
    cover_letter: '',
    resume: '',
});

const validationSchema = yup.object({
    name: yup.string().trim().required('Name is required.').max(255, 'Name is too long.'),
    email: yup.string().trim().required('Email is required.').email('Please enter a valid email address.').max(255, 'Email is too long.'),
    phone: yup.string().trim().required('Phone is required.').max(50, 'Phone is too long.'),
    cover_letter: yup.string().trim().required('Cover letter is required.').max(10000, 'Cover letter is too long.'),
    resume: yup
        .mixed()
        .required('Resume is required.')
        .test('fileType', 'Allowed file types: PDF, DOC, DOCX, ODT, RTF, TXT.', (file) => {
            if (!file) {
                return false;
            }

            // Some browsers/files provide empty or inconsistent MIME types,
            // so validate using extension as the primary check.
            const allowedExtensions = ['pdf', 'doc', 'docx', 'odt', 'rtf', 'txt'];
            const fileName = (file.name || '').toLowerCase();
            const extension = fileName.includes('.') ? fileName.split('.').pop() : '';

            return allowedExtensions.includes(extension || '');
        })
        .test('fileSize', 'Resume file size must not exceed 5MB.', (file) => {
            if (!file) {
                return false;
            }

            return file.size <= 5 * 1024 * 1024;
        }),
});

function openModal() {
    modalOpen.value = true;
    document.body.classList.add('jd-modal-open');
}

function closeModal() {
    modalOpen.value = false;
    document.body.classList.remove('jd-modal-open');
    resetForm();
}

function resetForm() {
    Object.assign(form, { name: '', email: '', phone: '', cover_letter: '', resume: null, resume_name: '' });
    clearErrors();

    if (resumeInput.value) {
        resumeInput.value.value = '';
    }
}

function clearErrors() {
    Object.keys(errors).forEach((key) => {
        errors[key] = '';
    });
}

watch(() => form.name,         () => { errors.name         = ''; });
watch(() => form.email,        () => { errors.email        = ''; });
watch(() => form.phone,        () => { errors.phone        = ''; });
watch(() => form.cover_letter, () => { errors.cover_letter = ''; });

function setError(field, message) {
    if (Object.prototype.hasOwnProperty.call(errors, field)) {
        errors[field] = message;
    }
}

async function validateForm() {
    clearErrors();

    // Keep source of truth with actual file input in case model gets stale.
    const selectedResumeFile = resumeInput.value?.files?.[0] ?? form.resume;

    try {
        await validationSchema.validate(
            {
                name: form.name,
                email: form.email,
                phone: form.phone,
                cover_letter: form.cover_letter,
                resume: selectedResumeFile,
            },
            { abortEarly: false }
        );

        form.resume = selectedResumeFile ?? null;

        return true;
    } catch (validationError) {
        if (validationError instanceof yup.ValidationError) {
            const issues = validationError.inner?.length ? validationError.inner : [validationError];

            issues.forEach((issue) => {
                const field = issue.path || 'resume';

                if (!errors[field]) {
                    setError(field, issue.message);
                }
            });
        }

        return false;
    }
}

function handleFile(e) {
    const file = e.target.files?.[0];
    if (file) {
        form.resume = file;
        form.resume_name = file.name;
        errors.resume = '';
    }
}

async function submitApplication() {
    if (submitting.value || !(await validateForm())) {
        notifyError('Please fix the validation errors and try again.');
        return;
    }

    submitting.value = true;

    try {
        const payload = new FormData();
        payload.append('name', form.name.trim());
        payload.append('email', form.email.trim());
        payload.append('phone', form.phone.trim());
        payload.append('cover_letter', form.cover_letter.trim());
        payload.append('resume', form.resume);

        const response = await window.axios.post(`/jobs/${job.id}/apply`, payload);

        notifySuccess(response.data?.message || 'Application submitted successfully.');
        closeModal();
    } catch (error) {
        const responseErrors = error?.response?.data?.errors ?? {};
        const errorMessage = error?.response?.data?.message || 'Unable to submit application. Please try again.';

        clearErrors();

        Object.keys(responseErrors).forEach((field) => {
            const value = responseErrors[field];
            const message = Array.isArray(value) ? value[0] : String(value ?? '');
            setError(field, message);
        });

        notifyError(errorMessage);
    } finally {
        submitting.value = false;
    }
}
</script>

<style scoped>
/* ── Hero ──────────────────────────────────────────────────────────────────── */
.jd-hero {
    position: relative;
    padding: 72px 0 60px;
    text-align: center;
    overflow: hidden;
}

.jd-hero-photo {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    z-index: 0;
}

.jd-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(13,27,42,0.82) 0%, rgba(19,85,165,0.72) 100%);
}

.jd-hero-content {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.jd-hero-icon {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: rgba(255,255,255,0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    margin-bottom: 4px;
}

.jd-hero-category {
    background: rgba(255,255,255,0.18);
    color: #fff;
    border-radius: 20px;
    padding: 4px 16px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

.jd-hero-title {
    font-size: 40px;
    font-weight: 800;
    color: #fff;
    margin: 0;
    line-height: 1.2;
    max-width: 780px;
}

.jd-hero-meta {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    color: rgba(255,255,255,0.7);
    margin: 0;
}

/* Breadcrumb */
.jd-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    margin-top: 6px;
    flex-wrap: wrap;
    justify-content: center;
}

.jd-breadcrumb-link {
    color: rgba(255,255,255,0.65);
    text-decoration: none;
    transition: color 0.2s;
}
.jd-breadcrumb-link:hover { color: #fff; }
.jd-breadcrumb-sep { color: rgba(255,255,255,0.4); }
.jd-breadcrumb-current {
    color: rgba(255,255,255,0.9);
    font-weight: 500;
    max-width: 300px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ── Body Layout ───────────────────────────────────────────────────────────── */
.jd-body { padding: 48px 0 72px; background: #f7f9fc; }

.jd-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 28px;
    align-items: start;
}

/* ── Main Card ─────────────────────────────────────────────────────────────── */
.jd-card {
    background: #ffffff;
    border: 1px solid #e2e6ea;
    border-radius: 10px;
    padding: 36px 40px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
}

.jd-section-title {
    font-size: 20px;
    font-weight: 700;
    color: #1355a5;
    margin: 0 0 20px;
    padding-bottom: 14px;
    border-bottom: 2px solid #e8f0fc;
}

.jd-description {
    font-size: 15px;
    line-height: 1.8;
    color: #4a5568;
}

/* ── Sidebar ───────────────────────────────────────────────────────────────── */
.jd-sidebar-card {
    background: #ffffff;
    border: 1px solid #e2e6ea;
    border-radius: 10px;
    padding: 28px 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    position: sticky;
    top: 100px;
}

.jd-sidebar-title {
    font-size: 17px;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid #e2e6ea;
}

.jd-overview-list {
    list-style: none;
    margin: 0 0 24px;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.jd-overview-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.jd-overview-icon {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: #e8f0fc;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1355a5;
    flex-shrink: 0;
    margin-top: 1px;
}

.jd-overview-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #a0aec0;
    margin-bottom: 2px;
}

.jd-overview-value {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
}

.jd-apply-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    background: #1355a5;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 14px 20px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    margin-bottom: 16px;
}

.jd-apply-btn:hover { background: #0d4485; transform: translateY(-1px); }

.jd-back-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 14px;
    color: #718096;
    text-decoration: none;
    transition: color 0.2s;
}
.jd-back-link:hover { color: #1355a5; }

/* ── Modal ─────────────────────────────────────────────────────────────────── */
.jd-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.55);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    backdrop-filter: blur(2px);
}

.jd-modal {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.14);
    width: 100%;
    max-width: 620px;
    max-height: 90vh;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}

.jd-modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    padding: 28px 32px 24px;
    border-bottom: 1px solid #e2e6ea;
    background: linear-gradient(135deg, #1355a5 0%, #0d6efd 100%);
    border-radius: 12px 12px 0 0;
}

.jd-modal-subtitle {
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: rgba(255,255,255,0.7);
    margin: 0 0 6px;
}

.jd-modal-title {
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 10px;
    line-height: 1.3;
}

.jd-modal-category {
    display: inline-block;
    background: rgba(255,255,255,0.18);
    color: #fff;
    border-radius: 20px;
    padding: 3px 12px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.jd-modal-close {
    background: rgba(255,255,255,0.15);
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #fff;
    flex-shrink: 0;
    transition: background 0.2s;
}
.jd-modal-close:hover { background: rgba(255,255,255,0.28); }

.jd-modal-body { padding: 32px; }

.jd-modal-form-heading {
    font-size: 16px;
    font-weight: 700;
    color: #1355a5;
    margin: 0 0 24px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e8f0fc;
}

.jd-apply-form { display: flex; flex-direction: column; gap: 20px; }
.jd-form-row   { display: flex; flex-direction: column; gap: 6px; }
.jd-form-error { color: #e53e3e; font-size: 12px; margin: 0; }

.jd-form-label    { font-size: 14px; font-weight: 600; color: #2d3748; }
.jd-form-required { color: #e53e3e; margin-left: 2px; }

.jd-form-input,
.jd-form-textarea {
    width: 100%;
    border: 1px solid #e2e6ea;
    border-radius: 6px;
    padding: 11px 14px;
    font-size: 14px;
    color: #2d3748;
    background: #ffffff;
    outline: none;
    transition: border-color 0.18s, box-shadow 0.18s;
    box-sizing: border-box;
}

.jd-form-input:focus,
.jd-form-textarea:focus {
    border-color: #1355a5;
    box-shadow: 0 0 0 3px rgba(19,85,165,0.12);
}

.jd-form-textarea { resize: vertical; min-height: 100px; }

.jd-phone-input { border: none !important; border-radius: 0 !important; box-shadow: none !important; }

.jd-form-row :deep(.iti) {
    border: 1px solid #e2e6ea;
    border-radius: 6px;
    overflow: visible;
    transition: border-color 0.18s, box-shadow 0.18s;
}
.jd-form-row :deep(.iti:focus-within) {
    border-color: #1355a5;
    box-shadow: 0 0 0 3px rgba(19,85,165,0.12);
}

.jd-file-wrap    { display: flex; flex-direction: column; gap: 6px; }
.jd-file-input   { display: none; }

.jd-file-display {
    display: flex;
    align-items: center;
    border: 1px solid #e2e6ea;
    border-radius: 6px;
    overflow: hidden;
    cursor: pointer;
}

.jd-file-name {
    flex: 1;
    padding: 11px 14px;
    font-size: 14px;
    color: #718096;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.jd-file-browse {
    background: #1355a5;
    color: #fff;
    border: none;
    padding: 11px 18px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    flex-shrink: 0;
    transition: background 0.2s;
}
.jd-file-browse:hover { background: #0d4485; }

.jd-file-hint { font-size: 12px; color: #718096; margin: 0; }

.jd-form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 8px;
    border-top: 1px solid #e2e6ea;
    margin-top: 4px;
}

.jd-form-cancel {
    background: none;
    border: 1px solid #e2e6ea;
    color: #718096;
    border-radius: 6px;
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.jd-form-cancel:hover { border-color: #718096; color: #2d3748; }

.jd-form-submit {
    background: #1355a5;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 12px 28px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}
.jd-form-submit:hover { background: #0d4485; }
.jd-form-submit:disabled { background: #7ea0c9; cursor: not-allowed; }


/* ── Modal Transition ──────────────────────────────────────────────────────── */
.modal-fade-enter-active,
.modal-fade-leave-active { transition: opacity 0.22s ease; }
.modal-fade-enter-from,
.modal-fade-leave-to     { opacity: 0; }
.modal-fade-enter-active .jd-modal,
.modal-fade-leave-active .jd-modal { transition: transform 0.22s ease, opacity 0.22s ease; }
.modal-fade-enter-from .jd-modal   { transform: translateY(-20px) scale(0.97); opacity: 0; }
.modal-fade-leave-to .jd-modal     { transform: translateY(10px) scale(0.97); opacity: 0; }

/* ── Responsive ────────────────────────────────────────────────────────────── */
@media (max-width: 900px) {
    .jd-layout { grid-template-columns: 1fr; }
    .jd-sidebar-card { position: static; }
}

@media (max-width: 768px) {
    .jd-hero       { padding: 52px 0 44px; }
    .jd-hero-title { font-size: 28px; }
    .jd-card       { padding: 24px 20px; }
    .jd-modal-header { padding: 22px 20px 18px; }
    .jd-modal-body   { padding: 24px 20px; }
    .jd-modal-title  { font-size: 18px; }
    .jd-form-actions { flex-direction: column-reverse; }
    .jd-form-cancel,
    .jd-form-submit  { width: 100%; text-align: center; }
}

@media (max-width: 480px) {
    .jd-hero-title { font-size: 22px; }
}
</style>
