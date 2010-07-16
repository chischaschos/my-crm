<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:template match="/">
        <table class="tablesorter">
            <xsl:attribute name="id">
                <xsl:value-of select="table/metadata/id" />
            </xsl:attribute>
            <xsl:apply-templates select="table/headers" />
            <xsl:apply-templates select="table/rows" />
        </table>
        <div id="pager" class="pager">
            <img src="js/jquery/tablesorter/addons/pager/icons/first.png" class="first"/>
            <img src="js/jquery/tablesorter/addons/pager/icons/prev.png" class="prev"/>
            <input type="text" class="pagedisplay"/>
            <img src="js/jquery/tablesorter/addons/pager/icons/next.png" class="next"/>
            <img src="js/jquery/tablesorter/addons/pager/icons/last.png" class="last"/>
            <select class="pagesize" disabled="disabled" style="display:none">
                <option selected="selected"  value="7">7</option>
            </select>
        </div>
	</xsl:template>
    <xsl:template match="headers">
        <thead>
            <tr>
                <xsl:for-each select="header">
                    <th>
                        <xsl:attribute name="class">
                            <xsl:value-of select="@class" />
                        </xsl:attribute>
                        <xsl:value-of select="@value" />
                    </th>
                </xsl:for-each>
            </tr>
        </thead>
    </xsl:template>
    <xsl:template match="rows">
        <tbody>
            <xsl:for-each select="row">
                <tr>
                    <xsl:attribute name="id">
                        <xsl:value-of select="@id" />
                    </xsl:attribute>
                    <xsl:attribute name="class">
                        <xsl:value-of select="@class" />
                    </xsl:attribute>
                    <xsl:for-each select="header">
                        <xsl:if test="value">
                            <td><xsl:value-of select="value" /></td>
                        </xsl:if>
                        <xsl:if test="@value">
                            <td>
                                <xsl:if test="@class">
                                    <xsl:attribute name="class">
                                        <xsl:value-of select="@class" />
                                    </xsl:attribute>
                                </xsl:if>
                                <xsl:value-of select="@value" />
                            </td>
                        </xsl:if>
                    </xsl:for-each>
                </tr>
            </xsl:for-each>
        </tbody>
	</xsl:template>
</xsl:stylesheet>
