initCatalogPage({
  getFilterFromText(text) {
    const normalized = (text || '').toLowerCase();

    if (normalized.includes('makerlab')) return 'makerlab';
    if (normalized.includes('modelli')) return 'modelli';
    if (normalized.includes('combo')) return 'combo';
    if (normalized.includes('hardware')) return 'hardware';
    if (normalized.includes('elettronica')) return 'elettronica';
    if (normalized.includes('strumenti')) return 'strumenti';

    return '';
  },
  getFilterFromLabel(label) {
    if (label.includes('makerlab')) return 'makerlab';
    if (label.includes('modelli')) return 'modelli';
    if (label.includes('combo')) return 'combo';
    if (label.includes('hardware')) return 'hardware';
    if (label.includes('elettronica')) return 'elettronica';
    if (label.includes('strumenti')) return 'strumenti';

    return '';
  },
});
