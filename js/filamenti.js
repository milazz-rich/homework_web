initCatalogPage({
  getFilterFromText(text) {
    const normalized = (text || '').toLowerCase();

    if (normalized.includes('pla')) return 'pla';
    if (normalized.includes('petg')) return 'petg';
    if (normalized.includes('abs') || normalized.includes('asa')) return 'abs-asa';
    if (normalized.includes('pc') || normalized.includes('tpu')) return 'pc-tpu';
    if (normalized.includes('pa') || normalized.includes('pet')) return 'pa-pet';
    if (normalized.includes('support')) return 'support';
    if (normalized.includes('fiber')) return 'fiber';

    return '';
  },
  getFilterFromLabel(label) {
    if (label.includes('pla')) return 'pla';
    if (label.includes('petg')) return 'petg';
    if (label.includes('abs') || label.includes('asa')) return 'abs-asa';
    if (label.includes('pc') || label.includes('tpu')) return 'pc-tpu';
    if (label.includes('pa') || label.includes('pet')) return 'pa-pet';
    if (label.includes('fiber')) return 'fiber';
    if (label.includes('support')) return 'support';

    return '';
  },
});
