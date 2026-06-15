/**
 * PMO Project Map
 * Interactive Leaflet-based project map
 */

var PMO_ProjectMap = {
	map: null,
	markers: [],
	markerCluster: null,

	init: function(zoom) {
		// Initialize map
		this.map = L.map('pmo-map').setView([pmoMap.centerLat, pmoMap.centerLng], zoom || 11);

		// Add map tiles
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '© OpenStreetMap contributors',
			maxZoom: 19,
		}).addTo(this.map);

		// Load projects
		this.loadProjects();

		// Set up filter handlers
		jQuery('#pmo-map-filter-category, #pmo-map-filter-status, #pmo-map-filter-lga').on('change', () => {
			this.loadProjects();
		});

		jQuery('#pmo-map-refresh-btn').on('click', () => {
			this.loadProjects();
		});
	},

	loadProjects: function() {
		const self = this;

		// Clear existing markers
		this.markers.forEach(marker => this.map.removeLayer(marker));
		this.markers = [];

		// Build filter parameters
		const params = {
			action: 'pmo_get_projects_data',
			nonce: pmoMap.nonce,
		};

		const category = jQuery('#pmo-map-filter-category').val();
		if (category) {
			params.category = category;
		}

		const status = jQuery('#pmo-map-filter-status').val();
		if (status) {
			params.status = status;
		}

		const lga = jQuery('#pmo-map-filter-lga').val();
		if (lga) {
			params.lga = lga;
		}

		// Fetch projects via AJAX
		jQuery.ajax({
			url: pmoMap.ajaxUrl,
			type: 'GET',
			data: params,
			success: function(response) {
				if (response.success) {
					self.addMarkers(response.data);
				}
			},
			error: function() {
				console.error('Failed to load projects');
			}
		});
	},

	addMarkers: function(projects) {
		const self = this;

		// Create a feature group to hold all markers
		const markersLayer = L.featureGroup();

		projects.forEach(project => {
			// Create marker with custom icon
			const markerColor = this.getColorByStatus(project.status);
			const marker = L.circleMarker([project.lat, project.lng], {
				radius: 8,
				fillColor: markerColor,
				color: '#fff',
				weight: 2,
				opacity: 1,
				fillOpacity: 0.8
			});

			// Create popup content
			let popupContent = `
				<div style="min-width: 250px; font-family: Arial, sans-serif;">
					<h4 style="margin: 0 0 10px 0; color: #003d7a;">
						<a href="${project.link}" target="_blank" style="color: #003d7a; text-decoration: none;">
							${project.title}
						</a>
					</h4>
					<p style="margin: 5px 0; font-size: 12px;">
						<strong>Status:</strong> <span style="background: ${markerColor}; color: white; padding: 2px 6px; border-radius: 3px;">${project.status}</span>
					</p>
					<p style="margin: 5px 0; font-size: 12px;">
						<strong>Progress:</strong> ${project.progress}%
					</p>
					<div style="height: 15px; background: #f0f0f0; border-radius: 3px; overflow: hidden; margin: 8px 0;">
						<div style="background: #27ae60; height: 100%; width: ${project.progress}%;"></div>
					</div>
					<a href="${project.link}" class="button" style="margin-top: 10px; font-size: 11px; padding: 5px 10px;">
						View Details
					</a>
				</div>
			`;

			marker.bindPopup(popupContent);
			marker.addTo(markersLayer);
			this.markers.push(marker);
		});

		// Add all markers to map
		markersLayer.addTo(this.map);

		// Fit bounds if markers exist
		if (this.markers.length > 0) {
			this.map.fitBounds(markersLayer.getBounds(), { padding: [50, 50] });
		}
	},

	getColorByStatus: function(status) {
		const colors = {
			'Planned': '#95a5a6',
			'Approved': '#3498db',
			'Procurement': '#9b59b6',
			'Mobilized': '#f39c12',
			'In Progress': '#e74c3c',
			'Near Completion': '#f1c40f',
			'Completed': '#27ae60',
			'Suspended': '#e67e22',
			'Cancelled': '#c0392b',
		};

		return colors[status] || '#34495e';
	}
};

// Make sure the map is responsive
jQuery(window).on('resize', function() {
	if (PMO_ProjectMap.map) {
		PMO_ProjectMap.map.invalidateSize();
	}
});
