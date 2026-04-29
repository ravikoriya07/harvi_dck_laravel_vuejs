<template>
    <div class="elementor-element elementor-element-0da32ca e-flex e-con-boxed e-con e-parent">
        <div class="e-con-inner">
            <div class="elementor-element elementor-element-70b37a9 pxl-post-layout-portfolio-1 elementor-widget elementor-widget-pxl_post_grid">
                <div class="elementor-widget-container">
                    <div
                        class="pxl-grid pxl-post-list pxl-portfolio-grid pxl-portfolio-grid-layout1 pxl-portfolio-style1 df pxl-effect--3d none"
                        data-start-page="1"
                        data-max-pages="1"
                        :data-total="projects.length"
                        :data-perpage="projects.length"
                        data-next-link=""
                        data-layout="fitRows">
                        <div class="pxl-grid-inner pxl-grid-masonry row" data-gutter="15">
                            <div
                                v-for="project in projects"
                                :key="project.href"
                                class="pxl-grid-item col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="pxl-post--inner" data-wow-duration="1.2s">
                                    <div class="pxl-post--featured">
                                        <AppLink :href="project.href">
                                            <img
                                                loading="lazy"
                                                decoding="async"
                                                class="no-lazyload"
                                                :src="project.image"
                                                :alt="project.title"
                                            />
                                        </AppLink>
                                        <div class="pxl-post-content-hide">
                                            <div class="pxl-post-content-top">
                                                <div class="pxl-post--content"></div>
                                            </div>
                                            <AppLink class="btn-readmore" :href="project.href">
                                                <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" enable-background="new 0 0 20 20" height="17" viewBox="0 0 20 20" width="21">
                                                    <path d="m12 2-1.4 1.4 5.6 5.6h-16.2v2h16.2l-5.6 5.6 1.4 1.4 8-8z" fill="#fff" />
                                                </svg>
                                            </AppLink>
                                        </div>
                                        <AppLink class="pxl-item--overlay" :href="project.href"></AppLink>
                                    </div>

                                    <div class="pxl-post--holder">
                                        <div class="pxl-post--category">
                                            <a href="#">{{ project.category }}</a>
                                        </div>
                                        <h5 class="pxl-post--title">
                                            <AppLink :href="project.href">{{ project.title }}</AppLink>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import AppLink from '@/Components/AppLink.vue';

const projects = [
    { title: 'London Borough of Haringey - Kitchen & Bathroom Refurbishment', category: 'Refurbishment', href: '/works/london-borough-of-haringey-kitchen-bathroom-refurbishment', image: '/assets/images/DCK-Northumberland-Park-15-3-600x600.png' },
    { title: 'LB Haringey - Void Refurbishment', category: 'Refurbishment', href: '/works/lb-haringey-void-refurbishment', image: '/assets/images/WhatsApp-Image-2025-09-25-at-15.46.02_0bb1e965-600x600.jpg' },
    { title: 'LB Hackney - Void Full Refurbishment Programme', category: 'Refurbishment', href: '/works/lb-hackney-void-full-refurbishment-programme', image: '/assets/images/WhatsApp-Image-2025-09-25-at-15.45.01_27d90c71-600x600.jpg' },
    { title: 'Extension and Refurbishment Project | LB Haringey', category: 'Refurbishment', href: '/works/extension-and-refurbishment-project-lb-haringey', image: '/assets/images/WhatsApp-Image-2025-09-25-at-15.41.48_402f275d-600x600.jpg' },
    { title: 'Haringey Aids & Adaptations Works', category: 'Aids and adaptations', href: '/works/haringey-aids-adaptations-works', image: '/assets/images/6509ab55-97be-4536-9747-018df8c0a9f5-600x600.jpg' },
    { title: 'Harrow Aids & Adaptations Works', category: 'Aids and adaptations', href: '/works/harrow-aids-adaptations-works', image: '/assets/images/0ab4bbf9-2f9c-42f1-b604-0c4230f95d6a-600x600.jpg' },
    { title: 'Aids & Adaptations, London Borough of Haringey', category: 'Aids and adaptations', href: '/works/aids-adaptations-london-borough-of-haringey', image: '/assets/images/LAS1-1-600x600.jpg' },
    { title: 'Southwark Void Refurbishment Programme 2025', category: 'Construction', href: '/works/southwark-void-refurbishment-programme-2025', image: '/assets/images/Untitled-design-1-1-600x600.png' },
    { title: 'Extension Project, Cuffley', category: 'Construction', href: '/works/extension-project-cuffley', image: '/assets/images/main-600x600.jpeg' },
    { title: 'Seething Wells Campus, Kingston University', category: 'Construction', href: '/works/seething-wells-campus-kingston-university', image: '/assets/images/IMG1-1-1-600x600.png' },
    { title: 'Seafront Hotel, Brighton', category: 'Construction', href: '/works/seafront-hotel-brighton', image: '/assets/images/Untitled-design-2-1-600x600.png' },
    { title: 'Great Arthur House, City of London', category: 'Construction', href: '/works/great-arthur-house-city-of-london', image: '/assets/images/image_3-7-1-600x600.png' },
    { title: 'Haringey Broadwater Farm Estate Fire Safety Works & Communal Decorations', category: 'Construction', href: '/works/designer-apartment', image: '/assets/images/JOB-70-of-155-scaled-600x600.jpg' },
    { title: 'Haringey Broadwater Farm Community Centre', category: 'Construction', href: '/works/haringey-broadwater-farm-community-centre', image: '/assets/images/projects/1/DCK-Broadwater-Farm-Community-Project-01-600x600.png' },
    { title: 'Void Property Renovations, London Borough of Haringey', category: 'Construction', href: '/works/void-property-renovations-london-borough-of-haringey', image: '/assets/images/WhatsApp-Image-2025-09-25-at-15.37.48_3369e48e-600x600.jpg' },
    { title: 'Void Property Renovations, Ministry of Defence', category: 'Construction', href: '/works/void-property-renovations-ministry-of-defence', image: '/assets/images/main-9-600x600.jpg' },
    { title: 'Kitchens & Bathrooms, London Borough of Haringey', category: 'Construction', href: '/works/kitchens-bathrooms-london-borough-of-haringey', image: '/assets/images/5-3-600x600.png' },
    { title: 'Haringey Kitchens & Bathrooms 2024 Programme', category: 'Construction', href: '/works/haringey-kitchens-bathrooms-2024-programme', image: '/assets/images/71bfe462-bc1a-4842-8e7e-abbe413f4e59-600x600.jpg' },
    { title: 'Haringey Community Benefit Society (HCBS) Voids Refurbishment Works', category: 'Construction', href: '/works/haringey-community-benefit-society-hcbs-voids-refurbishment-works', image: '/assets/images/2-5-600x600.png' },
    { title: 'Hackney Capital Works Programme Refurbishment', category: 'Construction', href: '/works/hackney-capital-works-programme-refurbishment', image: '/assets/images/1-8-600x600.png' },
];
</script>
