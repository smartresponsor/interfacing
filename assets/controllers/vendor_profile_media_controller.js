import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['coverInput', 'avatarInput', 'coverPreview', 'avatarPreview', 'status'];
    static values = {
        endpoint: { type: String, default: '/attachment/upload' },
        ownerId: String,
        ownerType: { type: String, default: 'vendor' },
        context: { type: String, default: 'profile' },
    };

    chooseCover() { this.coverInputTarget.click(); }
    chooseAvatar() { this.avatarInputTarget.click(); }

    async uploadCover(event) {
        await this.upload(event, 'cover', this.coverPreviewTarget, 'cover');
    }

    async uploadAvatar(event) {
        await this.upload(event, 'avatar', this.avatarPreviewTarget, 'image');
    }

    async upload(event, slot, previewTarget, previewMode) {
        const input = event.currentTarget;
        const file = input.files?.[0];

        if (!file) return;

        if (!file.type.startsWith('image/')) {
            this.setStatus('Only image files are supported.', true);
            input.value = '';
            return;
        }

        const localUrl = URL.createObjectURL(file);
        this.applyPreview(previewTarget, previewMode, localUrl);
        this.setBusy(true);
        this.setStatus(`Uploading ${slot}…`);

        const formData = new FormData();
        formData.append('file', file);
        formData.append('ownerType', this.ownerTypeValue);
        formData.append('ownerId', this.ownerIdValue);
        formData.append('context', this.contextValue);
        formData.append('slot', slot);
        formData.append('isPrimary', 'true');
        formData.append('title', slot === 'cover' ? 'Vendor profile cover' : 'Vendor profile avatar');
        formData.append('altText', slot === 'cover' ? 'Vendor profile cover image' : 'Vendor profile avatar');

        try {
            const response = await fetch(this.endpointValue, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
                headers: { Accept: 'application/json' },
            });
            const payload = await response.json().catch(() => ({}));

            if (!response.ok) {
                throw new Error(payload.message || payload.detail || `Upload failed with HTTP ${response.status}.`);
            }

            if (payload.downloadUrl) {
                this.applyPreview(previewTarget, previewMode, payload.downloadUrl);
            }

            this.setStatus(`${slot === 'cover' ? 'Cover' : 'Avatar'} updated.`);
        } catch (error) {
            this.setStatus(error instanceof Error ? error.message : 'Upload failed.', true);
        } finally {
            URL.revokeObjectURL(localUrl);
            input.value = '';
            this.setBusy(false);
        }
    }

    applyPreview(target, mode, url) {
        if (mode === 'cover') {
            let image = target.querySelector('.interfacing-vendor-profile-cover__image');
            if (!image) {
                image = document.createElement('img');
                image.className = 'interfacing-vendor-profile-cover__image';
                image.alt = 'Vendor profile cover';
                target.prepend(image);
            }
            target.querySelector('.interfacing-vendor-profile-cover__pattern')?.remove();
            image.src = url;
            return;
        }

        let image = target.querySelector('img');
        if (!image) {
            image = document.createElement('img');
            image.className = 'interfacing-vendor-profile-avatar__image';
            image.alt = 'Vendor profile avatar';
            target.replaceChildren(image);
        }
        image.src = url;
    }

    setBusy(busy) {
        this.element.toggleAttribute('aria-busy', busy);
        this.element.querySelectorAll('[data-vendor-profile-media-action]').forEach((button) => {
            button.disabled = busy;
        });
    }

    setStatus(message, error = false) {
        if (!this.hasStatusTarget) return;
        this.statusTarget.textContent = message;
        this.statusTarget.dataset.state = error ? 'error' : 'success';
    }
}
