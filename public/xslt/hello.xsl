<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet>
	<xsl:template match="/">
		<xsl:apply-templates select="page/message"/>
	</xsl:template>
	<xsl:template match="page/message">
		<div style="color:green">
			<xsl:value-of select="."/>
		</div>
	</xsl:template>
</xsl:stylesheet>

