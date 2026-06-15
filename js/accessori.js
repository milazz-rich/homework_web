initCatalogPage({
  getFilterFromText(text) {
    const normalized = (text || '').toLowerCase();

    if (normalized.includes('plate')) return 'piastre';
    if (normalized.includes('encoder')) return 'encoder';
    if (normalized.includes('purifier')) return 'purificatore';
    if (normalized.includes('laser')) return 'laser';
    if (normalized.includes('cutting')) return 'taglio';

    return '';
  },
  getFilterFromLabel(label) {
    if (label.includes('piastre')) return 'piastre';
    if (label.includes('encoder')) return 'encoder';
    if (label.includes('purificatore')) return 'purificatore';
    if (label.includes('laser')) return 'laser';
    if (label.includes('taglio')) return 'taglio';

    return '';
  },
});
