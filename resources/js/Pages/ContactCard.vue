<template>
    <Head :title="card.name" />

    <div class="card-page">
        <div class="card-container">
            <div class="banner"></div>

            <div class="profile-section">
                <img
                    v-if="card.profile_image"
                    :src="card.profile_image"
                    alt="Profile"
                    class="profile-image"
                >
                <p class="profile-name">{{ card.name }}</p>
                <p class="profile-title">{{ card.designation }}</p>
                <p class="profile-company">{{ card.company_name }}</p>
            </div>

            <ul class="contact-list">
                <a :href="`mailto:${card.email}`" class="contact-item">
                    <div class="contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                    </div>
                    <div class="contact-details">
                        <div class="contact-value">{{ card.email }}</div>
                        <div class="contact-label">Work</div>
                    </div>
                </a>

                <a :href="`tel:${phoneHref}`" class="contact-item">
                    <div class="contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>
                    </div>
                    <div class="contact-details">
                        <div class="contact-value">{{ card.phone }}</div>
                        <div class="contact-label">Mobile</div>
                    </div>
                </a>

                <a :href="card.website" target="_blank" class="contact-item">
                    <div class="contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                        </svg>
                    </div>
                    <div class="contact-details">
                        <div class="contact-value">{{ websiteDisplay }}</div>
                        <div class="contact-label">Website</div>
                    </div>
                </a>

                <a :href="mapsLink" target="_blank" class="contact-item">
                    <div class="contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                    </div>
                    <div class="contact-details">
                        <div class="contact-value">{{ card.office_address }}</div>
                        <div class="contact-label">Office Address</div>
                    </div>
                </a>
            </ul>

            <button class="save-button" @click="saveContact">Save Contact</button>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    card: {
        type: Object,
        required: true,
    },
});

const phoneHref = computed(() =>
    props.card.phone?.replace(/\s+/g, '') ?? ''
);

const websiteDisplay = computed(() =>
    props.card.website?.replace(/^https?:\/\//, '') ?? ''
);

const mapsLink = computed(() =>
    `https://maps.google.com/?q=${encodeURIComponent(props.card.office_address ?? '')}`
);

const saveContact = () => {
    const nameParts = props.card.name.trim().split(/\s+/);
    const firstName = nameParts[0] ?? '';
    const lastName  = nameParts.slice(1).join(' ');

    const vCard = [
        'BEGIN:VCARD',
        'VERSION:3.0',
        `N:${lastName};${firstName};;;`,
        `FN:${props.card.name}`,
        `EMAIL;TYPE=WORK:${props.card.email}`,
        `TEL;TYPE=CELL:${phoneHref.value}`,
        `ORG:${props.card.company_name?.toUpperCase()}`,
        `TITLE:${props.card.designation}`,
        `URL:${props.card.website}`,
        `ADR;TYPE=WORK:;;${props.card.office_address}`,
        'END:VCARD',
    ].join('\n');

    const blob = new Blob([vCard], { type: 'text/vcard' });
    const url  = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href     = url;
    link.download = `${props.card.slug}.vcf`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
};
</script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.card-page {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0;
}

.card-container {
    background: white;
    border-radius: 20px;
    max-width: 500px;
    width: 100%;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    overflow: hidden;
}

.banner {
    width: 100%;
    height: 200px;
    background-image: url('/assets/images/dck-logo-1.png');
    position: relative;
    background-size: 400px;
    background-repeat: no-repeat;
    background-position: center;
    background-color: #f8f9fa;
}

.banner::after {
    content: "";
    position: absolute;
    width: 100%;
    bottom: 0;
    height: 20px;
    background: linear-gradient(0deg, rgba(22, 29, 37, .05), transparent);
}

.profile-section {
    text-align: start;
    padding: 0 30px;
    margin-top: -60px;
    position: relative;
}

.profile-image {
    width: 120px;
    height: 120px;
    border-radius: 50% !important;
    border: 5px solid white !important;
    object-fit: cover;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2) !important;
}

.profile-name {
    font-size: 26px;
    font-weight: 700;
    color: #333;
    margin-top: 0;
    margin-bottom: 0;
}

.profile-title {
    font-size: 16px;
    color: #666;
    margin-bottom: 5px;
}

.profile-company {
    font-size: 16px;
    color: #888;
    margin-bottom: 10px;
}

.contact-list {
    list-style: none;
    padding: 0 30px;
    margin-bottom: 10px;
}

.contact-item {
    display: flex;
    align-items: center;
    padding: 15px;
    margin-bottom: 10px;
    background: #f8f9fa;
    border-radius: 12px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
}

.contact-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.contact-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
}

.contact-icon svg {
    width: 20px;
    height: 20px;
    fill: white;
}

.contact-details {
    flex-grow: 1;
    text-align: left;
}

.contact-value {
    font-size: 15px;
    font-weight: 500;
    color: #333;
    margin-bottom: 2px;
}

.contact-label {
    font-size: 13px;
    color: #888;
}

.save-button {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 15px 40px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 12px;
    cursor: pointer;
    margin: 0 30px 30px 30px;
    width: calc(100% - 60px);
    transition: all 0.3s ease;
}

.save-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
}

@media (max-width: 650px) {
    .card-page {
        align-items: flex-start;
    }

    .card-container {
        border-radius: 20px;
    }

    .banner {
        height: 130px;
        background-size: 230px;
    }

    .profile-section {
        margin-top: -40px;
        padding: 0 20px;
    }

    .profile-image {
        width: 100px;
        height: 100px !important;
        border-radius: 100% !important;
    }

    .profile-name {
        font-size: 22px;
        margin-top: 0;
    }

    .profile-title {
        font-size: 14px;
        margin-bottom: 0;
        margin-bottom: 8px;
    }

    .contact-list {
        padding: 0 15px;
        margin-bottom: 10px;
    }

    .contact-item {
        padding: 8px;
        margin-bottom: 5px;
    }

    .contact-icon {
        width: 36px;
        height: 36px;
    }

    .contact-icon svg {
        width: 18px;
        height: 18px;
    }

    .contact-value {
        font-size: 14px;
        line-height: 17px;
    }

    .contact-label {
        font-size: 12px;
    }

    .save-button {
        margin: 0 20px 15px 20px;
        width: calc(100% - 40px);
    }
}
</style>
