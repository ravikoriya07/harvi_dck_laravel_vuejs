<template>
    <!-- Filter Bar -->
    <section class="jobs-filter-bar">
        <div class="container">
            <form class="jobs-filter-form" @submit.prevent="applyFilters">
                <div class="jobs-filter-inner">
                    <div class="jobs-filter-keyword">
                        <span class="jobs-filter-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        </span>
                        <input
                            v-model="form.search"
                            type="text"
                            class="jobs-filter-input"
                            placeholder="Search by job title or keyword..."
                        />
                    </div>

                    <div class="jobs-filter-divider"></div>

                    <div class="jobs-filter-category">
                        <select v-model="form.category" class="jobs-filter-select">
                            <option value="">All Categories</option>
                            <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                                {{ cat.name }}
                            </option>
                        </select>
                        <span class="jobs-filter-select-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                        </span>
                    </div>

                    <button type="submit" class="jobs-filter-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        Search
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Results Count + Clear -->
    <section class="jobs-results-bar" v-if="hasAppliedFilters || pagination.total > 0">
        <div class="container">
            <div class="jobs-results-inner">
                <p class="jobs-results-count">
                    <span v-if="pagination.total > 0">
                        Showing <strong>{{ pagination.total }}</strong> {{ pagination.total === 1 ? 'position' : 'positions' }}
                        <template v-if="hasAppliedFilters"> matching your search</template>
                    </span>
                    <span v-else>No positions found</span>
                </p>
                <button v-if="hasAppliedFilters" class="jobs-clear-btn" @click="clearFilters">
                    Clear filters
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </section>

    <!-- Jobs Listing -->
    <section class="jobs-listing-section">
        <div class="container">

            <!-- Empty State -->
            <div v-if="jobs.length === 0" class="jobs-empty">
                <div class="jobs-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
                </div>
                <h3 class="jobs-empty-title">No positions available</h3>
                <p class="jobs-empty-text">
                    {{ hasAppliedFilters ? 'No jobs match your current search. Try adjusting your filters.' : 'There are no open positions at this time. Please check back soon.' }}
                </p>
                <button v-if="hasAppliedFilters" class="jobs-empty-clear" @click="clearFilters">Clear filters</button>
            </div>

            <!-- Job Cards -->
            <div v-else class="jobs-grid">
                <div
                    v-for="job in jobs"
                    :key="job.id"
                    class="job-card"
                    role="link"
                    tabindex="0"
                    @click="goToDetail(job)"
                    @keydown.enter="goToDetail(job)"
                >
                    <div class="job-card-inner">
                        <div class="job-card-logo">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                        </div>

                        <div class="job-card-content">
                            <div class="job-card-meta">
                                <span v-if="job.category" class="job-card-category">{{ job.category }}</span>
                                <span class="job-card-date">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                    {{ job.posted_at }}
                                </span>
                            </div>

                            <h3 class="job-card-title">{{ job.title }}</h3>

                            <p v-if="job.description" class="job-card-description">
                                {{ truncate(job.description, 160) }}
                            </p>
                        </div>

                        <div class="job-card-action">
                            <button class="job-apply-btn" @click.stop="openModal(job)">
                                Apply Now
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination — same structure as Blog page -->
            <nav v-if="pagination.last_page > 1" class="pxl-pagination-wrap" aria-label="Jobs pagination">
                <div class="pxl-pagination-links">
                    <template v-for="(link, index) in normalizedLinks" :key="index">

                        <!-- Prev arrow -->
                        <template v-if="link.variant === 'prev'">
                            <Link
                                v-if="link.url"
                                class="prev page-numbers"
                                preserve-scroll
                                :href="link.url"
                                aria-label="Previous page"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </Link>
                        </template>

                        <!-- Next arrow -->
                        <template v-else-if="link.variant === 'next'">
                            <Link
                                v-if="link.url"
                                class="next page-numbers"
                                preserve-scroll
                                :href="link.url"
                                aria-label="Next page"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </Link>
                        </template>

                        <!-- Ellipsis -->
                        <template v-else-if="link.variant === 'ellipsis'">
                            <span class="page-numbers dots" aria-hidden="true">…</span>
                        </template>

                        <!-- Page number -->
                        <template v-else>
                            <Link
                                v-if="link.url && !link.active"
                                class="page-numbers"
                                preserve-scroll
                                :href="link.url"
                                :aria-label="'Page ' + link.label"
                            >{{ link.label }}</Link>
                            <span
                                v-else-if="link.active"
                                class="page-numbers current"
                                :aria-label="'Page ' + link.label"
                                aria-current="page"
                            >{{ link.label }}</span>
                        </template>

                    </template>
                </div>
            </nav>

        </div>
    </section>

    <!-- Apply Now Modal -->
    <Teleport to="body">
        <Transition name="modal-fade">
            <div v-if="modal.open" class="jobs-modal-backdrop" @click.self="closeModal">
                <div class="jobs-modal" role="dialog" aria-modal="true" :aria-labelledby="'modal-title-' + modal.job?.id">
                    <div class="jobs-modal-header">
                        <div>
                            <p class="jobs-modal-subtitle">You are applying for</p>
                            <h2 :id="'modal-title-' + modal.job?.id" class="jobs-modal-title">{{ modal.job?.title }}</h2>
                            <span v-if="modal.job?.category" class="jobs-modal-category">{{ modal.job?.category }}</span>
                        </div>
                        <button class="jobs-modal-close" @click="closeModal" aria-label="Close modal">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="jobs-modal-body">
                        <h3 class="jobs-modal-form-heading">Apply For This Job</h3>

                        <form class="jobs-apply-form" @submit.prevent>
                            <div class="jobs-form-row">
                                <label class="jobs-form-label" for="apply-name">
                                    Name <span class="jobs-form-required">*</span>
                                </label>
                                <input
                                    id="apply-name"
                                    v-model="applyForm.name"
                                    type="text"
                                    class="jobs-form-input"
                                    placeholder="Your full name"
                                    required
                                />
                            </div>

                            <div class="jobs-form-row">
                                <label class="jobs-form-label" for="apply-email">
                                    Email <span class="jobs-form-required">*</span>
                                </label>
                                <input
                                    id="apply-email"
                                    v-model="applyForm.email"
                                    type="email"
                                    class="jobs-form-input"
                                    placeholder="your@email.com"
                                    required
                                />
                            </div>

                            <div class="jobs-form-row">
                                <label class="jobs-form-label" for="apply-phone">
                                    Phone <span class="jobs-form-required">*</span>
                                </label>
                                <IntlTelInput
                                    v-model="applyForm.phone"
                                    input-id="apply-phone"
                                    input-class="jobs-form-input jobs-phone-input"
                                    initial-country="gb"
                                />
                            </div>

                            <div class="jobs-form-row">
                                <label class="jobs-form-label" for="apply-cover">
                                    Cover Letter <span class="jobs-form-required">*</span>
                                </label>
                                <textarea
                                    id="apply-cover"
                                    v-model="applyForm.cover_letter"
                                    class="jobs-form-textarea"
                                    rows="5"
                                    placeholder="Tell us why you're a great fit for this role..."
                                    required
                                ></textarea>
                            </div>

                            <div class="jobs-form-row">
                                <label class="jobs-form-label" for="apply-resume">
                                    Attach Resume <span class="jobs-form-required">*</span>
                                </label>
                                <div class="jobs-file-wrap">
                                    <input
                                        id="apply-resume"
                                        ref="resumeInput"
                                        type="file"
                                        class="jobs-file-input"
                                        accept=".pdf,.doc,.docx,.odt,.rtf,.txt"
                                        @change="handleFileChange"
                                    />
                                    <div class="jobs-file-display" @click="resumeInput?.click()">
                                        <span class="jobs-file-name">{{ applyForm.resume_name || 'No file chosen' }}</span>
                                        <button type="button" class="jobs-file-browse">Browse</button>
                                    </div>
                                    <p class="jobs-file-hint">Accepted: PDF, DOC, DOCX, ODT, RTF, TXT</p>
                                </div>
                            </div>

                            <div class="jobs-form-actions">
                                <button type="button" class="jobs-form-cancel" @click="closeModal">Cancel</button>
                                <button type="submit" class="jobs-form-submit">Submit Application</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { computed, reactive, ref, watch } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import IntlTelInput from '@/Components/IntlTelInput.vue';

const props = defineProps({
    pagination: { type: Object, required: true },
    categories: { type: Array, default: () => [] },
    filters:    { type: Object, default: () => ({}) },
});

const jobs = computed(() => props.pagination.data ?? []);

// ── Filters ─────────────────────────────────────────────────────────────────
const form = reactive({
    search:   props.filters.search   ?? '',
    category: props.filters.category ?? '',
});

watch(() => props.filters, (v) => {
    form.search   = v.search   ?? '';
    form.category = v.category ?? '';
});

/** Filters actually applied (URL / server response), not draft text in the bar */
const hasAppliedFilters = computed(() => {
    const f = props.filters ?? {};
    const search = String(f.search ?? '').trim();
    const cat = f.category;
    const categoryApplied = cat !== null && cat !== undefined && String(cat).trim() !== '';
    return search.length > 0 || categoryApplied;
});

function applyFilters() {
    const query = {};
    if (form.search)   query.search   = form.search;
    if (form.category) query.category = form.category;
    router.get('/jobs', query, { preserveScroll: true, replace: true });
}

function clearFilters() {
    form.search   = '';
    form.category = '';
    router.get('/jobs', {}, { preserveScroll: true, replace: true });
}

function goToDetail(job) {
    router.visit(job.href);
}

// ── Pagination ───────────────────────────────────────────────────────────────
const normalizedLinks = computed(() => {
    const links = props.pagination.links ?? [];
    return links.map((link) => {
        const text = String(link.label)
            .replace(/<[^>]*>/g, '')
            .replace(/&nbsp;/g, ' ')
            .trim();
        const lower = text.toLowerCase();
        let variant = 'page';
        if (lower.includes('previous')) variant = 'prev';
        else if (lower.includes('next')) variant = 'next';
        else if (text === '...' || text === '…') variant = 'ellipsis';
        return { ...link, label: text, variant };
    });
});

// ── Apply Modal ──────────────────────────────────────────────────────────────
const modal = reactive({ open: false, job: null });

const applyForm = reactive({
    name:         '',
    email:        '',
    phone:        '',
    cover_letter: '',
    resume:       null,
    resume_name:  '',
});

const resumeInput = ref(null);

function openModal(job) {
    modal.job  = job;
    modal.open = true;
    document.body.classList.add('jobs-modal-open');
}

function closeModal() {
    modal.open = false;
    modal.job  = null;
    document.body.classList.remove('jobs-modal-open');
    resetForm();
}

function resetForm() {
    applyForm.name         = '';
    applyForm.email        = '';
    applyForm.phone        = '';
    applyForm.cover_letter = '';
    applyForm.resume       = null;
    applyForm.resume_name  = '';
}

function handleFileChange(event) {
    const file = event.target.files?.[0];
    if (file) {
        applyForm.resume      = file;
        applyForm.resume_name = file.name;
    }
}

// ── Helpers ──────────────────────────────────────────────────────────────────
function truncate(text, max) {
    if (!text) return '';
    const plain = text.replace(/<[^>]*>/g, '').replace(/\s+/g, ' ').trim();
    return plain.length > max ? plain.slice(0, max).trimEnd() + '…' : plain;
}
</script>

<style scoped>
/* ── Filter Bar ──────────────────────────────────────────────────────────── */
.jobs-filter-bar {
    background: #f0f4f8;
    padding: 28px 0;
    border-bottom: 1px solid #e2e6ea;
}

.jobs-filter-form { width: 100%; }

.jobs-filter-inner {
    display: flex;
    align-items: center;
    background: #ffffff;
    border: 1px solid #e2e6ea;
    border-radius: 50px;
    padding: 6px 6px 6px 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    gap: 0;
}

.jobs-filter-keyword {
    display: flex;
    align-items: center;
    flex: 1;
    gap: 10px;
    min-width: 0;
}

.jobs-filter-icon { color: #718096; flex-shrink: 0; display: flex; }

.jobs-filter-input {
    flex: 1;
    border: none;
    outline: none;
    background: transparent;
    font-size: 15px;
    color: #2d3748;
    min-width: 0;
}

.jobs-filter-input::placeholder { color: #a0aec0; }

.jobs-filter-divider {
    width: 1px;
    height: 28px;
    background: #e2e6ea;
    margin: 0 16px;
    flex-shrink: 0;
}

.jobs-filter-category {
    position: relative;
    flex-shrink: 0;
    min-width: 160px;
}

.jobs-filter-select {
    appearance: none;
    border: none;
    outline: none;
    background: transparent;
    font-size: 15px;
    color: #2d3748;
    padding-right: 24px;
    cursor: pointer;
    width: 100%;
}

.jobs-filter-select-icon {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: #718096;
    display: flex;
}

.jobs-filter-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #1355a5;
    color: #fff;
    border: none;
    border-radius: 50px;
    padding: 12px 28px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    flex-shrink: 0;
    margin-left: 10px;
    transition: background 0.2s;
}

.jobs-filter-btn:hover { background: #0d4485; }

/* ── Results Bar ─────────────────────────────────────────────────────────── */
.jobs-results-bar {
    padding: 16px 0;
    border-bottom: 1px solid #e2e6ea;
}

.jobs-results-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}

.jobs-results-count {
    margin: 0;
    font-size: 14px;
    color: #718096;
}

.jobs-results-count strong { color: #2d3748; font-weight: 600; }

.jobs-clear-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    background: none;
    border: 1px solid #e2e6ea;
    border-radius: 20px;
    padding: 6px 14px;
    font-size: 13px;
    color: #718096;
    cursor: pointer;
    transition: all 0.2s;
}

.jobs-clear-btn:hover { border-color: #c53030; color: #c53030; }

/* ── Listing Section ─────────────────────────────────────────────────────── */
.jobs-listing-section { padding: 40px 0 60px; background: #f7f9fc; min-height: 400px; }

/* ── Empty State ─────────────────────────────────────────────────────────── */
.jobs-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 80px 20px;
    text-align: center;
}

.jobs-empty-icon {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    background: #e8f0fc;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 24px;
    color: #1355a5;
}

.jobs-empty-title {
    font-size: 22px;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 10px;
}

.jobs-empty-text {
    font-size: 15px;
    color: #718096;
    max-width: 420px;
    margin: 0 0 24px;
    line-height: 1.6;
}

.jobs-empty-clear {
    background: none;
    border: 2px solid #1355a5;
    color: #1355a5;
    border-radius: 6px;
    padding: 10px 24px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.jobs-empty-clear:hover { background: #1355a5; color: #fff; }

/* ── Job Grid ────────────────────────────────────────────────────────────── */
.jobs-grid {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* ── Job Card ────────────────────────────────────────────────────────────── */
.job-card {
    background: #ffffff;
    border: 1px solid #e2e6ea;
    border-radius: 8px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    cursor: pointer;
}

.job-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(0,0,0,0.12);
    border-color: #c3d4f0;
}

.job-card-inner {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 24px 28px;
}

.job-card-logo {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    background: #e8f0fc;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #1355a5;
}

.job-card-content { flex: 1; min-width: 0; }

.job-card-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
    flex-wrap: wrap;
}

.job-card-category {
    background: #e8f0fc;
    color: #1355a5;
    border-radius: 20px;
    padding: 3px 12px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.job-card-date {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    color: #718096;
}

.job-card-title {
    font-size: 18px;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 8px;
    line-height: 1.35;
}

.job-card-description {
    font-size: 14px;
    color: #718096;
    line-height: 1.6;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.job-card-action { flex-shrink: 0; margin-left: auto; }

.job-apply-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #1355a5;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 12px 22px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: background 0.2s, transform 0.15s;
}

.job-apply-btn:hover {
    background: #0d4485;
    transform: translateX(2px);
}


/* ── Modal Backdrop ──────────────────────────────────────────────────────── */
.jobs-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    backdrop-filter: blur(2px);
}

/* ── Modal Box ───────────────────────────────────────────────────────────── */
.jobs-modal {
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

.jobs-modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    padding: 28px 32px 24px;
    border-bottom: 1px solid #e2e6ea;
    background: linear-gradient(135deg, #1355a5 0%, #0d6efd 100%);
    border-radius: 12px 12px 0 0;
}

.jobs-modal-subtitle {
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: rgba(255,255,255,0.7);
    margin: 0 0 6px;
}

.jobs-modal-title {
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 10px;
    line-height: 1.3;
}

.jobs-modal-category {
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

.jobs-modal-close {
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

.jobs-modal-close:hover { background: rgba(255,255,255,0.28); }

.jobs-modal-body { padding: 32px; }

.jobs-modal-form-heading {
    font-size: 16px;
    font-weight: 700;
    color: #1355a5;
    margin: 0 0 24px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e8f0fc;
}

/* ── Apply Form ──────────────────────────────────────────────────────────── */
.jobs-apply-form { display: flex; flex-direction: column; gap: 20px; }

.jobs-form-row { display: flex; flex-direction: column; gap: 6px; }

.jobs-form-label {
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
}

.jobs-form-required { color: #e53e3e; margin-left: 2px; }

.jobs-form-input,
.jobs-form-textarea {
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

.jobs-form-input:focus,
.jobs-form-textarea:focus {
    border-color: #1355a5;
    box-shadow: 0 0 0 3px rgba(19, 85, 165, 0.12);
}

.jobs-form-textarea { resize: vertical; min-height: 100px; }

/*
 * Phone: IntlTelInput.vue (+ intl-tel-input styles).
 * .jobs-phone-input removes duplicate outer border; flag+dial live in .iti prefix.
 */
.jobs-phone-input {
    border: none !important;
    border-radius: 0 !important;
    box-shadow: none !important;
}

.jobs-form-row :deep(.iti) {
    border: 1px solid #e2e6ea;
    border-radius: 6px;
    overflow: visible;
    transition: border-color 0.18s, box-shadow 0.18s;
}

.jobs-form-row :deep(.iti:focus-within) {
    border-color: #1355a5;
    box-shadow: 0 0 0 3px rgba(19, 85, 165, 0.12);
}

/* File input */
.jobs-file-wrap { display: flex; flex-direction: column; gap: 6px; }

.jobs-file-input { display: none; }

.jobs-file-display {
    display: flex;
    align-items: center;
    border: 1px solid #e2e6ea;
    border-radius: 6px;
    overflow: hidden;
    cursor: pointer;
}

.jobs-file-name {
    flex: 1;
    padding: 11px 14px;
    font-size: 14px;
    color: #718096;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.jobs-file-browse {
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

.jobs-file-browse:hover { background: #0d4485; }

.jobs-file-hint { font-size: 12px; color: #718096; margin: 0; }

/* Form actions */
.jobs-form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 8px;
    border-top: 1px solid #e2e6ea;
    margin-top: 4px;
}

.jobs-form-cancel {
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

.jobs-form-cancel:hover { border-color: #718096; color: #2d3748; }

.jobs-form-submit {
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

.jobs-form-submit:hover { background: #0d4485; }

/* ── Modal Transition ────────────────────────────────────────────────────── */
.modal-fade-enter-active,
.modal-fade-leave-active { transition: opacity 0.22s ease; }

.modal-fade-enter-from,
.modal-fade-leave-to { opacity: 0; }

.modal-fade-enter-active .jobs-modal,
.modal-fade-leave-active .jobs-modal { transition: transform 0.22s ease, opacity 0.22s ease; }

.modal-fade-enter-from .jobs-modal { transform: translateY(-20px) scale(0.97); opacity: 0; }

.modal-fade-leave-to .jobs-modal { transform: translateY(10px) scale(0.97); opacity: 0; }

/* ── Responsive ──────────────────────────────────────────────────────────── */
@media (max-width: 768px) {
    .jobs-filter-inner {
        flex-direction: column;
        border-radius: 12px;
        padding: 16px;
        gap: 12px;
        align-items: stretch;
    }

    .jobs-filter-keyword { min-width: 0; }

    .jobs-filter-divider {
        width: 100%;
        height: 1px;
        margin: 0;
    }

    .jobs-filter-category { min-width: 0; }

    .jobs-filter-btn {
        margin-left: 0;
        justify-content: center;
        padding: 13px 28px;
    }

    .job-card-inner {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
        padding: 20px;
    }

    .job-card-action { width: 100%; margin-left: 0; }

    .job-apply-btn { width: 100%; justify-content: center; }

    .jobs-modal-header { padding: 22px 20px 18px; }
    .jobs-modal-body   { padding: 24px 20px; }
    .jobs-modal-title  { font-size: 18px; }
    .jobs-form-actions { flex-direction: column-reverse; }
    .jobs-form-cancel,
    .jobs-form-submit  { width: 100%; text-align: center; justify-content: center; }
}

@media (max-width: 480px) {
    .jobs-results-inner { flex-direction: column; align-items: flex-start; gap: 8px; }
    .jobs-modal-title { font-size: 16px; }
}
</style>
