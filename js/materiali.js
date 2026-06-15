initCatalogPage({
  getFilterFromText(text) {
    const normalized = (text || '').toLowerCase();

    if (normalized.includes('compensato') || normalized.includes('tavola')) return 'legno';
    if (normalized.includes('acril') || normalized.includes('plexi')) return 'acrilico';
    if (normalized.includes('vinile') || normalized.includes('adesiv')) return 'vinile';
    if (normalized.includes('varie') || normalized.includes('per saperne')) return 'varie';

    return '';
  },
  getFilterFromLabel(label) {
    if (label.includes('legno')) return 'legno';
    if (label.includes('acril')) return 'acrilico';
    if (label.includes('vinile')) return 'vinile';
    if (label.includes('varie')) return 'varie';

    return '';
  },
});
